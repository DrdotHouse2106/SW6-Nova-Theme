const { PluginBaseClass } = window;

export const RECENTLY_VIEWED_KEY = 'nova-recently-viewed';

/**
 * „Zuletzt angesehen“
 *
 * - Auf der Produktseite wird die Produkt-ID im Browser gespeichert (localStorage,
 *   neueste zuerst, max. 20). Auf dem Server wird nichts gespeichert.
 * - Sind IDs vorhanden, wird die Liste als HTML-Fragment geladen und als Slider
 *   aus Shopwares Standard-Produktboxen angezeigt.
 * - Nach dem Einfügen wird auf document das Event „nova:products-rendered“ ausgelöst,
 *   damit z. B. das Tag-Manager-Plugin die Produkte erfassen kann.
 */
export default class NovaRecentlyViewedPlugin extends PluginBaseClass {
    static options = {
        url: '',
        currentId: null,
        maxStored: 20,
        maxShown: 12,
    };

    init() {
        const ids = this._read();

        if (this.options.currentId) {
            this._write([this.options.currentId, ...ids.filter((id) => id !== this.options.currentId)]);
        }

        const shown = ids.filter((id) => id !== this.options.currentId).slice(0, this.options.maxShown);
        if (shown.length > 0 && this.options.url) {
            this._load(shown);
        }
    }

    _read() {
        try {
            const value = JSON.parse(window.localStorage.getItem(RECENTLY_VIEWED_KEY) || '[]');
            // Nur gültige IDs, ohne Duplikate (erste Fundstelle = neueste bleibt erhalten)
            return Array.isArray(value) ? [...new Set(value.filter((id) => /^[0-9a-f]{32}$/.test(id)))] : [];
        } catch (e) {
            return [];
        }
    }

    _write(ids) {
        try {
            window.localStorage.setItem(RECENTLY_VIEWED_KEY, JSON.stringify(ids.slice(0, this.options.maxStored)));
        } catch (e) {
            // Speicher gesperrt (z. B. privater Modus) → Liste wird einfach nicht geführt
        }
    }

    async _load(ids) {
        try {
            const response = await fetch(`${this.options.url}?ids=${ids.join('|')}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (!response.ok) {
                return;
            }

            const html = (await response.text()).trim();
            if (html === '') {
                return;
            }

            this.el.innerHTML = html;
            this.el.classList.add('is-loaded');
            this._registerSlider();

            // Shopware-Plugins in den Produktboxen aktivieren (Merkzettel, In den Warenkorb …)
            if (window.PluginManager && typeof window.PluginManager.initializePlugins === 'function') {
                window.PluginManager.initializePlugins();
            }

            document.dispatchEvent(new CustomEvent('nova:products-rendered', { detail: { container: this.el } }));
        } catch (e) {
            // Netzwerkfehler → Liste bleibt leer, die Seite funktioniert normal weiter
        }
    }

    _registerSlider() {
        const track = this.el.querySelector('.nova-product-slider-track');
        if (!track) {
            return;
        }

        this.el.querySelectorAll('[data-nova-slide]').forEach((button) => {
            button.addEventListener('click', () => {
                const direction = Number(button.getAttribute('data-nova-slide'));
                track.scrollBy({ left: direction * track.clientWidth * 0.8, behavior: 'smooth' });
            });
        });
    }
}
