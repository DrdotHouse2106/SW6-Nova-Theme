# Nova Theme für Shopware 6

🇬🇧 [English version](README.en.md)

Modernes, modulares und **schnelles** Storefront-Theme für Shopware 6.6 und 6.7 – optimiert für jede Bildschirmgröße, vom Smartphone bis zum 4K-Monitor.

## Highlights

| Bereich | Umsetzung |
|---|---|
| **Performance** | Systemschrift statt Webfonts (kein Download, kein Render-Blocking), nur ~2 KB eigenes JavaScript, JS-Plugins werden per Lazy-Import nur bei Bedarf geladen, `content-visibility` für den Footer, feste Bild-Seitenverhältnisse gegen Layout-Shift (CLS) |
| **Responsive** | Mobile-First, fließende Typografie und Abstände via `clamp()`, **Container Queries** für Produktkarten, zweispaltiges Listing auf Smartphones, 44–48 px Touch-Ziele, kein iOS-Auto-Zoom bei Formularen |
| **Modular** | Jedes SCSS-Modul (Header, Footer, Produktkarte, …) ist eine eigene Datei und kann einzeln deaktiviert werden. Design-Tokens als CSS-Variablen (`--nova-*`) |
| **Konfigurierbar** | Farben, Schriften, Eckenradien, Inhaltsbreite, Sticky-/Auto-Hide-Header und Animationen direkt in der Administration einstellbar |
| **Barrierearm** | Sichtbare Fokus-Ringe, `prefers-reduced-motion` wird respektiert, Hover-Effekte nur auf Geräten mit Maus |

## Installation

```bash
# 1. Plugin in die Shopware-Installation kopieren
cd <shopware-root>/custom/plugins
git clone https://github.com/DrdotHouse2106/sw6-theme.git NovaTheme

# 2. Installieren und aktivieren
cd <shopware-root>
bin/console plugin:refresh
bin/console plugin:install --activate NovaTheme

# 3. Theme dem Verkaufskanal zuweisen und kompilieren
bin/console theme:change NovaTheme --all
bin/console cache:clear
```

Alternativ in der Administration unter **Inhalte → Themes** das „Nova Theme“ auswählen und dem Verkaufskanal zuweisen.

## Theme-Konfiguration

Unter **Inhalte → Themes → Nova Theme** stehen neben den Standard-Optionen zur Verfügung:

- **Nova: Layout** – maximale Inhaltsbreite, Eckenradien (Karten/Buttons), Flächenfarbe, Sticky-Header, Header beim Runterscrollen ausblenden
- **Nova: Performance & Effekte** – Webfonts deaktivieren, dezente Einblend-Animationen

## Struktur

```
src/
├── NovaTheme.php                      Plugin-Klasse (ThemeInterface)
└── Resources/
    ├── theme.json                     Theme-Definition & Konfigurationsfelder
    ├── views/storefront/
    │   ├── base.html.twig             Body-Klassen aus der Theme-Konfiguration
    │   └── layout/meta.html.twig      theme-color, Webfont-Steuerung
    └── app/storefront/
        ├── src/
        │   ├── main.js                Registriert JS-Plugins (Lazy-Import)
        │   ├── plugin/                Sticky-Header, Einblend-Animation
        │   └── scss/
        │       ├── overrides.scss     Bootstrap-/Shopware-Variablen (vor dem Kern)
        │       ├── base.scss          Einstiegspunkt – Module ein-/ausschalten
        │       ├── abstracts/         Variablen, Mixins, nova-fluid()
        │       ├── base/              Tokens, Typografie
        │       ├── layout/            Container, Header, Navigation, Footer
        │       ├── components/        Buttons, Formulare, Produktkarte, PDP, CMS, Offcanvas
        │       └── utilities/         Animationen, Hilfsklassen
        └── dist/                      Fertig gebautes JavaScript
```

### Module an- und abschalten

In `src/Resources/app/storefront/src/scss/base.scss` einfach die entsprechende `@import`-Zeile auskommentieren und das Theme neu kompilieren (`bin/console theme:compile`).

### Hilfsklassen für Erlebniswelten

In CMS-Sektionen/-Blöcken (Feld „CSS-Klasse“) nutzbar:

| Klasse | Wirkung |
|---|---|
| `nova-surface` | Hintergrund in Flächenfarbe |
| `nova-section` | Fließender Innenabstand oben/unten |
| `nova-rounded` | Theme-Eckenradius |
| `nova-shadow` | Weicher Schatten |

Mit dem Attribut `data-nova-reveal` kann jedes Element die Einblend-Animation erhalten.

## Entwicklung

**Innerhalb von Shopware** (empfohlen):

```bash
bin/build-storefront.sh        # Produktions-Build inkl. Code-Splitting
bin/watch-storefront.sh        # Hot-Reload während der Entwicklung
```

**Ohne Shopware** (nur das Theme-JavaScript bauen):

```bash
cd src/Resources/app/storefront
npm install
npm run build
```

## Weitere Performance-Tipps für den Shop

- HTTP-Cache und Reverse-Proxy (Varnish/Fastly) aktivieren, `APP_ENV=prod`
- Thumbnail-Größen passend zum Layout definieren und WebP/AVIF ausliefern
- Nicht genutzte Plugins deaktivieren – jedes Plugin bringt eigenes CSS/JS mit
- OPcache, Redis für Sessions/Cache sowie Elasticsearch/OpenSearch bei großen Katalogen

## Kompatibilität

- Shopware 6.6.x und 6.7.x
- Alle aktuellen Browser (Container Queries ab Chrome 105, Safari 16, Firefox 110)

## Lizenz

MIT
