/*
 * Nova Theme – JavaScript-Einstiegspunkt
 * ---------------------------------------------------------------
 * Alle Plugins werden per dynamischem Import registriert. Der Code
 * wird dadurch nur geladen, wenn das passende Element existiert
 * (Code-Splitting → kleineres Haupt-Bundle, schnellerer Seitenaufbau).
 */
const PluginManager = window.PluginManager;

PluginManager.register(
    'NovaCompactHeader',
    () => import('./plugin/nova-compact-header.plugin'),
    'body.nova-compact-header'
);

PluginManager.register(
    'NovaLoaderBar',
    () => import('./plugin/nova-loader-bar.plugin'),
    'body.nova-loader-bar'
);

PluginManager.register(
    'NovaReveal',
    () => import('./plugin/nova-reveal.plugin'),
    'body.nova-animations'
);

PluginManager.register(
    'NovaConfetti',
    () => import('./plugin/nova-confetti.plugin'),
    'body.nova-confetti'
);

PluginManager.register(
    'NovaRecentlyViewed',
    () => import('./plugin/nova-recently-viewed.plugin'),
    '[data-nova-recently-viewed]'
);

/*
 * Leere Absätze in Nova-Bausteinen der Erlebniswelten entfernen.
 * Aus anderen Programmen kopierte Texte enthalten oft <p> ohne Inhalt; deren Abstände
 * summieren sich in Karten und Bändern zu großen Lücken. Absätze mit Bild, Video oder
 * Formularfeld bleiben unangetastet.
 */
document.querySelectorAll('.cms-block[class*="nova-"] .cms-element-text p').forEach((p) => {
    const text = p.textContent.replace(/[\s ]/g, '');
    if (text === '' && !p.querySelector('img, picture, video, iframe, svg, input, button')) {
        p.remove();
    }
});
