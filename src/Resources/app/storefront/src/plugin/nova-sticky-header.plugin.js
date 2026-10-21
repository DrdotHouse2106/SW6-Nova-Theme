const { PluginBaseClass } = window;

/**
 * Setzt Zustandsklassen am <body>, abhängig von der Scrollposition:
 *  - nova-is-scrolled   → Seite wurde gescrollt (Schatten am Header)
 *  - nova-header-hidden → beim Runterscrollen ausblenden (optional)
 *
 * Nutzt einen passiven Scroll-Listener + requestAnimationFrame,
 * damit das Scrollen niemals blockiert wird.
 */
export default class NovaStickyHeaderPlugin extends PluginBaseClass {
    static options = {
        scrolledClass: 'nova-is-scrolled',
        hiddenClass: 'nova-header-hidden',
        autoHideClass: 'nova-header-autohide',
        threshold: 8,
        hideOffset: 200,
    };

    init() {
        this._lastY = window.scrollY;
        this._ticking = false;
        this._autoHide = this.el.classList.contains(this.options.autoHideClass);

        window.addEventListener('scroll', this._onScroll.bind(this), { passive: true });
        this._update();
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
        const { scrolledClass, hiddenClass, threshold, hideOffset } = this.options;

        this.el.classList.toggle(scrolledClass, y > threshold);

        if (this._autoHide && Math.abs(y - this._lastY) > threshold) {
            // Header nicht verstecken, solange ein Offcanvas/Modal offen ist
            const overlayOpen = document.querySelector('.offcanvas.show, .modal.show');
            this.el.classList.toggle(hiddenClass, !overlayOpen && y > this._lastY && y > hideOffset);
            this._lastY = y;
        }
    }
}
