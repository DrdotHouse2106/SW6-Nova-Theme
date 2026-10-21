const { PluginBaseClass } = window;

/**
 * Kleine Konfetti-Animation auf der Bestellabschluss-Seite.
 * Ohne externe Bibliothek, läuft ca. 3 Sekunden, einmal pro Bestellung
 * und nicht bei aktivierter Einstellung „Bewegung reduzieren“.
 */
export default class NovaConfettiPlugin extends PluginBaseClass {
    static options = {
        particles: 140,
        duration: 3200,
        colors: ['#ffd23f', '#ee4266', '#3bceac', '#540d6e', '#0ead69', '#4d9de0'],
    };

    init() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || this._alreadyShown()) {
            return;
        }

        this._canvas = document.createElement('canvas');
        this._canvas.className = 'nova-confetti-canvas';
        this._canvas.setAttribute('aria-hidden', 'true');
        document.body.appendChild(this._canvas);
        this._ctx = this._canvas.getContext('2d');

        this._resize();
        this._pieces = Array.from({ length: this.options.particles }, () => this._createPiece());
        this._start = performance.now();
        window.requestAnimationFrame(this._frame.bind(this));
    }

    _alreadyShown() {
        const key = `nova-confetti:${window.location.pathname}${window.location.search}`;
        try {
            if (window.sessionStorage.getItem(key)) {
                return true;
            }
            window.sessionStorage.setItem(key, '1');
        } catch (e) {
            // Speicher nicht verfügbar → Konfetti trotzdem zeigen
        }
        return false;
    }

    _resize() {
        const ratio = window.devicePixelRatio || 1;
        this._w = window.innerWidth;
        this._h = window.innerHeight;
        this._canvas.width = this._w * ratio;
        this._canvas.height = this._h * ratio;
        this._ctx.scale(ratio, ratio);
    }

    _createPiece() {
        const { colors } = this.options;
        return {
            x: this._w / 2 + (Math.random() - 0.5) * this._w * 0.3,
            y: this._h * 0.35,
            vx: (Math.random() - 0.5) * 14,
            vy: -Math.random() * 14 - 4,
            size: Math.random() * 7 + 5,
            rot: Math.random() * Math.PI,
            vr: (Math.random() - 0.5) * 0.3,
            color: colors[Math.floor(Math.random() * colors.length)],
        };
    }

    _frame(now) {
        const progress = (now - this._start) / this.options.duration;
        const ctx = this._ctx;

        ctx.clearRect(0, 0, this._w, this._h);
        ctx.globalAlpha = Math.max(0, 1 - Math.max(0, progress - 0.7) / 0.3);

        this._pieces.forEach((p) => {
            p.vy += 0.35;
            p.vx *= 0.99;
            p.x += p.vx;
            p.y += p.vy;
            p.rot += p.vr;

            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.size / 2, -p.size / 4, p.size, p.size / 2);
            ctx.restore();
        });

        if (progress < 1) {
            window.requestAnimationFrame(this._frame.bind(this));
        } else {
            this._canvas.remove();
        }
    }
}
