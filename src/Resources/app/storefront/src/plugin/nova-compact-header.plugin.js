const { PluginBaseClass } = window;

/**
 * Kompakter Header beim Scrollen.
 *
 * Sobald der normale Header aus dem Bild gescrollt ist, wird er als
 * schmale, fixierte Leiste wieder eingeblendet (Logo, Menü, Suche,
 * Aktionen). Der Platz des Headers wird per Padding reserviert,
 * damit der Inhalt dabei nicht springt.
 *
 * Zustandsklassen am <body>:
 *  - nova-header-fixed  → kompakte Leiste aktiv
 *  - nova-header-hidden → beim Runterscrollen ausgeblendet (optional)
 */
export default class NovaCompactHeaderPlugin extends PluginBaseClass {
    static options = {
        headerSelector: '.header-main',
        fixedClass: 'nova-header-fixed',
        hiddenClass: 'nova-header-hidden',
        autoHideClass: 'nova-header-autohide',
        delta: 8,
    };

    init() {
        this._header = document.querySelector(this.options.headerSelector);
        if (!this._header) {
            return;
        }

        this._autoHide = this.el.classList.contains(this.options.autoHideClass);
        this._lastY = window.scrollY;
        this._ticking = false;
        this._fixed = false;

        this._measure();
        window.addEventListener('scroll', this._onScroll.bind(this), { passive: true });
        window.addEventListener('resize', this._onResize.bind(this), { passive: true });
        this._update();
    }

    _measure() {
        if (this._fixed) {
            return;
        }

        const rect = this._header.getBoundingClientRect();
        this._height = rect.height;
        this._threshold = rect.bottom + window.scrollY;
    }

    _onResize() {
        this._measure();
        this._onScroll();
    }

    _onScroll() {
        if (this._ticking) {
            return;
        }

        this._ticking = true;
        window.requestAnimationFrame(() => {
            this._update();
            this._ticking = false;
        });
    }

    _update() {
        const y = Math.max(window.scrollY, 0);
        const shouldFix = y > this._threshold;

        if (shouldFix !== this._fixed) {
            this._fixed = shouldFix;
            this.el.style.paddingTop = shouldFix ? `${this._height}px` : '';
            this.el.classList.toggle(this.options.fixedClass, shouldFix);
            this.el.classList.remove(this.options.hiddenClass);
        }

        if (this._autoHide && this._fixed && Math.abs(y - this._lastY) > this.options.delta) {
            // Nie ausblenden, solange ein Offcanvas, Modal oder die Suche offen ist
            const busy = document.querySelector('.offcanvas.show, .modal.show, .search-suggest-container')
                || this._header.contains(document.activeElement);
            this.el.classList.toggle(this.options.hiddenClass, !busy && y > this._lastY);
        }

        if (Math.abs(y - this._lastY) > this.options.delta) {
            this._lastY = y;
        }
    }
}
