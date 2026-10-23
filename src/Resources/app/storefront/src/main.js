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

/*
 * Datei-Anhänge im Kontaktformular: Anzahl und Größe schon im Browser prüfen,
 * damit niemand erst nach dem Hochladen eine Fehlermeldung bekommt.
 * Der Server prüft zusätzlich (ContactUploadSubscriber).
 */
document.querySelectorAll('input[type="file"][data-nova-max-files]').forEach((input) => {
    const mb = 1024 * 1024;
    input.addEventListener('change', () => {
        const files = Array.from(input.files || []);
        const maxFiles = Number(input.dataset.novaMaxFiles) || 5;
        const maxMb = Number(input.dataset.novaMaxMb) || 10;
        const maxTotalMb = Number(input.dataset.novaMaxTotalMb) || 20;
        const tooBig = files.find((file) => file.size > maxMb * mb);
        const total = files.reduce((sum, file) => sum + file.size, 0);

        let message = '';
        if (files.length > maxFiles) {
            message = input.dataset.novaErrorCount;
        } else if (tooBig) {
            message = input.dataset.novaErrorSize.replace('%name%', tooBig.name);
        } else if (total > maxTotalMb * mb) {
            message = input.dataset.novaErrorTotal;
        }

        input.setCustomValidity(message);
        input.classList.toggle('is-invalid', message !== '');
        if (message) {
            input.reportValidity();
        }
    });
});
