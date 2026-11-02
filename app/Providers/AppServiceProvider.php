<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use PostHog\PostHog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $projectToken = config('services.posthog.project_token');

        // Sin token no se inicializa el SDK: la aplicación debe seguir funcionando
        // y las vistas deben caer al respaldo (página original) sin lanzar errores.
        if (!is_string($projectToken) || trim($projectToken) === '') {
            return;
        }

        try {
            PostHog::init($projectToken, [
                'host' => config('services.posthog.host'),
                'feature_flag_request_timeout_ms' => 2500,
                'disableGeoip' => true,
            ]);
        } catch (\Throwable $e) {
            // No se debe romper la web por un fallo de analítica.
            Log::warning('No se pudo inicializar PostHog en PHP.', [
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
