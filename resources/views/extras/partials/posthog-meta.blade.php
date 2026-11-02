@php
    /*
     * Project API Key pública de PostHog (phc_...). No debe contener claves
     * personales (phx_...) ni secretos de proyecto (phs_...).
     */
    $posthogToken = config('services.posthog.project_token');
    $posthogHost = config('services.posthog.host') ?: 'https://us.i.posthog.com';
    $posthogExperimentKey = $posthogExperimentKey ?? config('services.posthog.experiment_key');
    $posthogEnvironment = $posthogEnvironment ?? config('services.posthog.environment');
    $posthogTestEnvironment = $posthogTestEnvironment ?? config('services.posthog.test_environment');
    $posthogInternalUser = $posthogInternalUser ?? false;
    $posthogAuthUserId = auth()->id();
@endphp

<meta name="rv-posthog-token" content="{{ $posthogToken }}">
<meta name="rv-posthog-host" content="{{ $posthogHost }}">
<meta name="rv-posthog-experiment-key" content="{{ $posthogExperimentKey }}">
<meta name="rv-posthog-distinct-id" content="{{ $posthogDistinctId ?? '' }}">
<meta name="rv-posthog-ab-variant" content="{{ $abVariant ?? '' }}">
<meta name="rv-posthog-ab-entry" content="{{ ($abEntry ?? false) ? '1' : '0' }}">
<meta name="rv-posthog-environment" content="{{ $posthogEnvironment }}">
<meta name="rv-posthog-test-environment" content="{{ $posthogTestEnvironment }}">
<meta name="rv-posthog-internal-user" content="{{ $posthogInternalUser ? '1' : '0' }}">
<meta name="rv-posthog-auth-user-id" content="{{ $posthogAuthUserId }}">
