<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use PostHog\PostHog;

/**
 * Resuelve la variante del experimento A/B de PostHog y registra la exposición.
 *
 * Reglas importantes:
 * - Solo se consideran variantes válidas "control" y "test".
 * - Si la flag está apagada, en borrador o devuelve cualquier otro valor, el
 *   visitante ve la página original pero NO se registra una exposición.
 * - La variante se guarda en la sesión de Laravel para que el visitante
 *   conserve la misma versión durante la navegación.
 */
class AbExperimentService
{
    private const VALID_VARIANTS = ['control', 'test'];

    private const SESSION_ASSIGNMENT_PREFIX = 'posthog.ab.assignment.';

    private const SESSION_EXPOSURE_PREFIX = 'posthog.ab.exposed.';

    private const SESSION_MISS_PREFIX = 'posthog.ab.miss.';

    /** Minutos que se recuerda una evaluación sin variante antes de reintentar. */
    private const MISS_TTL_MINUTES = 1;

    public function key(): ?string
    {
        $key = config('services.posthog.experiment_key');

        return is_string($key) && trim($key) !== '' ? trim($key) : null;
    }

    public function enabled(): bool
    {
        $token = config('services.posthog.project_token');

        return $this->key() !== null
            && is_string($token)
            && trim($token) !== '';
    }

    /**
     * Devuelve la asignación guardada para la sesión actual, si sigue siendo
     * válida para la clave de experimento configurada.
     *
     * @return array{key: string, variant: string}|null
     */
    public function assignmentFromSession(): ?array
    {
        $key = $this->key();

        if ($key === null) {
            return null;
        }

        $assignment = session()->get($this->assignmentSessionKey($key));

        if (!is_array($assignment) || ($assignment['key'] ?? null) !== $key) {
            return null;
        }

        $variant = $assignment['variant'] ?? null;

        return in_array($variant, self::VALID_VARIANTS, true)
            ? ['key' => $key, 'variant' => $variant]
            : null;
    }

    /**
     * Evalúa la feature flag y persiste la variante válida en la sesión.
     * No envía exposición aquí: la exposición se registra solo cuando el
     * visitante realmente recibe la página del experimento.
     *
     * @return array{key: string, variant: string}|null
     */
    public function resolve(string $distinctId): ?array
    {
        if (!$this->enabled() || trim($distinctId) === '') {
            return null;
        }

        $existing = $this->assignmentFromSession();

        if ($existing !== null) {
            return $existing;
        }

        $key = $this->key();

        if ($key === null || $this->recentlyMissed($key)) {
            return null;
        }

        try {
            // getEventProperties() lee los valores sin disparar $feature_flag_called.
            // La exposición se controla manualmente más abajo.
            $evaluations = PostHog::evaluateFlags(
                $distinctId,
                [],
                [],
                [],
                false,
                null,
                [$key]
            );

            $properties = $evaluations->getEventProperties();
            $variant = $properties['$feature/' . $key] ?? null;

            if (!is_string($variant) || !in_array($variant, self::VALID_VARIANTS, true)) {
                // No se guarda como asignación ni se envía exposición.
                session()->put($this->missSessionKey($key), now()->getTimestamp());

                return null;
            }

            $assignment = ['key' => $key, 'variant' => $variant];
            session()->put($this->assignmentSessionKey($key), $assignment);

            return $assignment;
        } catch (\Throwable $e) {
            Log::warning('No se pudo evaluar la feature flag de PostHog.', [
                'experiment_key' => $key,
                'exception' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Registra una única exposición $feature_flag_called por sesión y variante.
     *
     * @param array{key: string, variant: string} $assignment
     */
    public function expose(array $assignment, string $distinctId): void
    {
        if (!$this->enabled() || trim($distinctId) === '') {
            return;
        }

        $variant = $assignment['variant'] ?? null;
        $key = $assignment['key'] ?? null;

        if (!is_string($key) || !in_array($variant, self::VALID_VARIANTS, true)) {
            return;
        }

        $exposureKey = $this->exposureSessionKey($key, $distinctId, $variant);
        $cacheKey = $this->exposureCacheKey($key, $distinctId, $variant);

        if (session()->has($exposureKey) || Cache::has($cacheKey)) {
            return;
        }

        try {
            PostHog::capture([
                'distinct_id' => $distinctId,
                'event' => '$feature_flag_called',
                'properties' => array_merge([
                    '$feature_flag' => $key,
                    '$feature_flag_key' => $key,
                    '$feature_flag_response' => $variant,
                    'locally_evaluated' => false,
                    'experiment_key' => $key,
                    'ab_variant' => $variant,
                ], $this->commonProperties()),
            ]);

            session()->put($exposureKey, true);
            // Evita repetir la exposición si Laravel regenera la sesión
            // (por ejemplo, justo después de iniciar sesión).
            Cache::put($cacheKey, true, now()->addDays(30));
        } catch (\Throwable $e) {
            Log::warning('No se pudo registrar la exposición del experimento en PostHog.', [
                'experiment_key' => $key,
                'exception' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Propiedades comunes que también se envían desde JavaScript.
     *
     * @return array<string, mixed>
     */
    public function commonProperties(): array
    {
        $properties = [
            'app' => 'repuestos-vargas',
        ];

        $environment = config('services.posthog.environment');

        if (is_string($environment) && $environment !== '') {
            $properties['environment'] = $environment;
        }

        $testEnvironment = config('services.posthog.test_environment');

        if (is_string($testEnvironment) && $testEnvironment !== '') {
            $properties['test_environment'] = $testEnvironment;
        }

        // Permite excluir el tráfico del equipo en los análisis oficiales.
        if (auth()->check() && (string) (auth()->user()->role ?? '') === 'admin') {
            $properties['is_internal'] = true;
        }

        return $properties;
    }

    private function assignmentSessionKey(string $key): string
    {
        return self::SESSION_ASSIGNMENT_PREFIX . sha1($key);
    }

    private function exposureSessionKey(string $key, string $distinctId, string $variant): string
    {
        return self::SESSION_EXPOSURE_PREFIX . sha1($key . '|' . $distinctId . '|' . $variant);
    }

    private function exposureCacheKey(string $key, string $distinctId, string $variant): string
    {
        return 'posthog:exposure:' . sha1($key . '|' . $distinctId . '|' . $variant);
    }

    private function missSessionKey(string $key): string
    {
        return self::SESSION_MISS_PREFIX . sha1($key);
    }

    private function recentlyMissed(string $key): bool
    {
        $missedAt = session()->get($this->missSessionKey($key));

        if (!is_numeric($missedAt)) {
            return false;
        }

        return (now()->getTimestamp() - (int) $missedAt) < (self::MISS_TTL_MINUTES * 60);
    }
}
