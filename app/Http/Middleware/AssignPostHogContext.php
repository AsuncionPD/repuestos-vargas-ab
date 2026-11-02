<?php

namespace App\Http\Middleware;

use App\Services\AbExperimentService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Asigna un identificador anónimo persistente al visitante y comparte con las
 * vistas el contexto necesario para PostHog (mismo distinct_id en PHP y JS).
 */
class AssignPostHogContext
{
    public const COOKIE_NAME = 'rv_visitor_id';

    private const COOKIE_MINUTES = 60 * 24 * 365;

    public function __construct(private readonly AbExperimentService $experiment)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $visitorId = $request->cookie(self::COOKIE_NAME);
        $isNewVisitor = !$this->isValidVisitorId($visitorId);

        if ($isNewVisitor) {
            $visitorId = (string) Str::uuid();

            Cookie::queue(cookie(
                self::COOKIE_NAME,
                $visitorId,
                self::COOKIE_MINUTES,
                '/',
                null,
                $request->isSecure(),
                true,
                false,
                'lax'
            ));
        }

        $request->attributes->set('posthog_distinct_id', $visitorId);

        $assignment = $this->experiment->assignmentFromSession();
        $isInternal = $request->user() !== null
            && (string) ($request->user()->role ?? '') === 'admin';

        View::share([
            'posthogDistinctId' => $visitorId,
            'posthogExperimentKey' => $this->experiment->key(),
            'posthogEnvironment' => config('services.posthog.environment'),
            'posthogTestEnvironment' => config('services.posthog.test_environment'),
            'posthogInternalUser' => $isInternal,
            // Puede ser sobrescrito por el controlador cuando resuelve la flag.
            'abVariant' => $assignment['variant'] ?? null,
            'abEntry' => false,
        ]);

        return $next($request);
    }

    private function isValidVisitorId(mixed $value): bool
    {
        return is_string($value)
            && preg_match(
                '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
                $value
            ) === 1;
    }
}
