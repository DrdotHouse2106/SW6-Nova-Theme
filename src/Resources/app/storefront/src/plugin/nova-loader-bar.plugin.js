const { PluginBaseClass } = window;

/**
 * Schmaler Fortschrittsbalken am oberen Rand, sobald ein interner
 * Link angeklickt wird. Gibt sofortiges Feedback beim Seitenwechsel.
 */
export default class NovaLoaderBarPlugin extends PluginBaseClass {
    init() {
        this._bar = document.createElement('div');
        this._bar.className = 'nova-loader';
        this._bar.setAttribute('aria-hidden', 'true');
        document.body.appendChild(this._bar);

        document.addEventListener('click', this._onClick.bind(this));
        // Beim Zurück-Navigieren (Back-Forward-Cache) Balken zurücksetzen
        window.addEventListener('pageshow', () => this._bar.classList.remove('is-loading'));
    }

    _onClick(event) {
        if (event.defaultPrevented || event.button !== 0
            || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        const link = event.target.closest('a[href]');
        if (!link || link.target === '_blank' || link.hasAttribute('download')
            || link.closest('[data-off-canvas-cart], [data-ajax-modal], [data-bs-toggle]')) {
            return;
        }

        const url = new URL(link.href, window.location.href);
        const samePage = url.pathname === window.location.pathname && url.search === window.location.search;
        if (url.origin !== window.location.origin || samePage || !/^https?:$/.test(url.protocol)) {
            return;
        }

        this._bar.classList.remove('is-loading');
        void this._bar.offsetWidth; // Animation neu starten
        this._bar.classList.add('is-loading');
    }
}
