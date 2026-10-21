/*
 * Nova Theme – JavaScript-Einstiegspunkt
 * ---------------------------------------------------------------
 * Alle Plugins werden per dynamischem Import registriert. Der Code
 * wird dadurch nur geladen, wenn das passende Element existiert
 * (Code-Splitting → kleineres Haupt-Bundle, schnellerer Seitenaufbau).
 */
const PluginManager = window.PluginManager;

PluginManager.register(
    'NovaStickyHeader',
    () => import('./plugin/nova-sticky-header.plugin'),
    'body.nova-sticky-header'
);

PluginManager.register(
    'NovaReveal',
    () => import('./plugin/nova-reveal.plugin'),
    'body.nova-animations'
);
