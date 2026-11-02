import posthog from 'posthog-js';

/**
 * Analítica de Repuestos Vargas.
 *
 * - Un solo init de PostHog por página.
 * - Mismo distinct_id que usa Laravel para evaluar la flag A/B.
 * - Eventos del experimento: navegación del navbar y CTA del hero.
 */

const readMeta = (name) => {
    const element = document.querySelector(`meta[name="rv-posthog-${name}"]`);

    return element?.content?.trim() ?? '';
};

const readLocal = (key) => {
    try {
        return window.localStorage.getItem(key);
    } catch {
        return null;
    }
};

const writeLocal = (key, value) => {
    try {
        window.localStorage.setItem(key, value);
    } catch {
        // No es bloqueante.
    }
};

const isValidVariant = (value) => value === 'control' || value === 'test';

const ALIAS_KEY = 'rv_posthog_alias_done';

const boot = () => {
    if (window.__rvAnalyticsLoaded) {
        return;
    }
    window.__rvAnalyticsLoaded = true;

    const token = readMeta('token') || import.meta.env.VITE_POSTHOG_PROJECT_TOKEN || '';
    const host = readMeta('host') || import.meta.env.VITE_POSTHOG_HOST || 'https://us.i.posthog.com';
    const experimentKey = readMeta('experiment-key');
    const distinctId = readMeta('distinct-id');
    const rawVariant = readMeta('ab-variant');
    const variant = isValidVariant(rawVariant) || rawVariant === 'preview'
        ? rawVariant
        : 'unknown';
    const environment = readMeta('environment');
    const testEnvironment = readMeta('test-environment');
    const internalUser = readMeta('internal-user') === '1';
    const authUserId = readMeta('auth-user-id');

    if (!token && !import.meta.env.VITE_POSTHOG_PROJECT_TOKEN) {
        // Sin Project API Key no se inicializa PostHog. La web sigue funcionando.
        return;
    }

    try {
        posthog.init(token, {
            api_host: host,
            capture_pageview: true,
            capture_pageleave: false,
            autocapture: false,
            person_profiles: 'identified_only',
            disable_session_recording: true,
            bootstrap: distinctId
                ? { distinctID: distinctId, isIdentifiedID: false }
                : undefined,
            loaded: (client) => {
                // Garantiza que JavaScript use exactamente el mismo distinct_id
                // con el que Laravel evaluó la feature flag.
                if (distinctId && client.get_distinct_id() !== distinctId) {
                    client.identify(distinctId);
                }

                // Usuarios autenticados: se enlaza la cuenta con la persona
                // anónima sin cambiar el distinct_id del experimento, para no
                // duplicar participantes ni hacer que cambie la variante.
                if (authUserId && readLocal(ALIAS_KEY) !== authUserId) {
                    client.alias(`user_${authUserId}`);
                    writeLocal(ALIAS_KEY, authUserId);
                }
            },
        });
    } catch (error) {
        console.warn('[analytics] No se pudo inicializar PostHog.', error);
        return;
    }

    const commonProperties = {
        app: 'repuestos-vargas',
        ab_variant: variant,
    };

    if (experimentKey) {
        commonProperties.experiment_key = experimentKey;
    }
    if (environment) {
        commonProperties.environment = environment;
    }
    if (testEnvironment) {
        commonProperties.test_environment = testEnvironment;
    }
    if (internalUser) {
        commonProperties.is_internal = true;
    }

    // is_preview se envía solo en los eventos de la vista previa, nunca como
    // super-propiedad persistente: así una prueba en /prueba-redisenado no
    // contamina eventos oficiales posteriores del mismo navegador.
    posthog.unregister('is_preview');
    posthog.register(commonProperties);

    // Muchos eventos se disparan justo antes de una navegación completa
    // (navbar o CTA del hero). Sin estas opciones el evento queda en la
    // cola de PostHog y se pierde al descargarse la página.
    // send_instantly evita el batching y el transporte actual ya está
    // comprobado en PostHog.
    const capture = (event, properties = {}) => {
        console.log('[PostHog] Enviando:', event);

        const eventProperties = {
            ...properties,
            ab_variant: variant,
        };

        if (variant === 'preview') {
            eventProperties.is_preview = true;
        }

        return posthog.capture(
            event,
            eventProperties,
            {
                transport: 'fetch',
                send_instantly: true,
            }
        );
    };

    const closestFromEvent = (event, selector) => {
        const target = event.target;

        return target instanceof Element ? target.closest(selector) : null;
    };

    document.addEventListener('click', (event) => {
        const navigation = closestFromEvent(event, '[data-ab-navigation]');

        if (navigation) {
            capture('header_navigation_click', {
                navigation_type:
                    navigation.dataset.abNavigationType ||
                    navigation.dataset.abNavigation ||
                    'unknown',
                destination:
                    navigation.dataset.abNavigation || 'unknown',
                link_location:
                    navigation.dataset.abNavigationLocation || 'unknown',
                link_url:
                    navigation.getAttribute('href') || '',
            });
        }

        const heroCta = closestFromEvent(event, '[data-ab-hero-cta]');

        if (heroCta) {
            capture('hero_cta_click', {
                cta_name: heroCta.dataset.abHeroCta || 'ver_todo',
                cta_location: 'hero',
                destination: heroCta.getAttribute('href') || '',
            });
        }
    }, true);
};

boot();
