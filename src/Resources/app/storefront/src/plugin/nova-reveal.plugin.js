const { PluginBaseClass } = window;

/**
 * Blendet Inhalte dezent ein, sobald sie in den sichtbaren Bereich
 * scrollen. Elemente, die beim Laden bereits sichtbar sind, werden
 * nie versteckt → kein Flackern und keine Verschlechterung von LCP.
 */
export default class NovaRevealPlugin extends PluginBaseClass {
    static options = {
        selector: '.cms-block, .product-box, [data-nova-reveal]',
        hiddenClass: 'nova-reveal',
        visibleClass: 'is-visible',
        rootMargin: '0px 0px -10% 0px',
    };

    init() {
        if (!('IntersectionObserver' in window)
            || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        this._initial = new WeakSet();
        this._observer = new IntersectionObserver(this._onIntersect.bind(this), {
            rootMargin: this.options.rootMargin,
        });

        this.el.querySelectorAll(this.options.selector).forEach((el) => this._observer.observe(el));
    }

    _onIntersect(entries) {
        const { hiddenClass, visibleClass } = this.options;

        entries.forEach(({ target, isIntersecting }) => {
            // Erster Aufruf pro Element: Startzustand bestimmen
            if (!this._initial.has(target)) {
                this._initial.add(target);

                if (isIntersecting) {
                    this._observer.unobserve(target);
                } else {
                    target.classList.add(hiddenClass);
                }
                return;
            }

            if (isIntersecting) {
                target.classList.add(visibleClass);
                this._observer.unobserve(target);
            }
        });
    }
}
