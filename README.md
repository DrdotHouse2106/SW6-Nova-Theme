# Nova Theme für Shopware 6

🇬🇧 [English version](README.en.md)

Modernes, modulares und **schnelles** Storefront-Theme für Shopware 6.6 und 6.7 – optimiert für jede Bildschirmgröße, vom Smartphone bis zum 4K-Monitor.

## Highlights

| Bereich | Umsetzung |
|---|---|
| **Performance** | keine externen Schriften oder Skripte, nur ~7 KB eigenes JavaScript, JS-Plugins werden per Lazy-Import nur bei Bedarf geladen, `content-visibility` für den Footer, feste Bild-Seitenverhältnisse gegen Layout-Shift (CLS) |
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

## Funktionen

| Funktion | Beschreibung |
|---|---|
| **Topbar** | Infotext (optional verlinkt), Telefon, E-Mail und Öffnungszeiten über dem Header |
| **Kompakter Header** | Sobald der Header aus dem Bild gescrollt ist, erscheint eine schmale Leiste mit Logo, Menü, Suche, Merkzettel, Konto und Warenkorb – ohne dass der Inhalt springt. Optional beim Runterscrollen ausblenden |
| **Ladebalken** | Schmaler Fortschrittsbalken beim Klick auf interne Links |
| **Artikelzähler** | „2126 Artikel“ über dem Listing, aktualisiert sich beim Filtern |
| **Konfetti** | Kurze Animation nach erfolgreicher Bestellung (ohne externe Bibliothek) |
| **Produktbilder** | Wahlweise ganz zeigen (freigestellt) oder Fläche füllen (Fotos) |
| **Zuletzt angesehen** | Slider unter der Produktseite und im Warenkorb. Nur mit Zustimmung im Cookie-Dialog („Komfortfunktionen“), beim Widerruf wird die Liste sofort gelöscht. Die Liste liegt nur im Browser des Kunden (localStorage, max. 20 Produkte) – auf dem Server wird nichts gespeichert |
| **Modernes Checkout** | Fortschrittsanzeige (Warenkorb → Adresse → Prüfen → Fertig), Versand- und Zahlungsarten als Auswahlkarten, mitlaufende Zusammenfassung auf dem Desktop, Bestell-Button auf dem Smartphone immer sichtbar, schlanker Checkout-Header |
| **Modernes Kundenkonto** | Konto-Menü als Karte, Karten für Übersicht, Profil, Adressen und Bestellungen, Login und Registrierung mit großen Eingabefeldern |
| **Konto löschen** | Gut sichtbarer Bereich „Konto löschen“ im Profil mit Sicherheitsabfrage |

## Einstellungen

### Plugin-Konfiguration (pro Verkaufskanal)

**Erweiterungen → Meine Erweiterungen → Nova Theme → Konfigurieren** – oben den Verkaufskanal wählen:

- **Topbar** – an/aus, Infotext, Link, Telefon, E-Mail, Öffnungszeiten
- **Header** – kompakter Header beim Scrollen, Ladebalken
- **Produktlisting** – Artikelanzahl anzeigen
- **Zuletzt angesehen** – Liste an/aus
- **Checkout** – Konfetti nach der Bestellung

### Theme-Konfiguration (Farben & Layout)

**Inhalte → Themes → Nova Theme**:

- **Theme-Farben / Typografie** – Primär-, Sekundär-, Kauf-Button-Farbe, Schriftart (Standard: Inter, wird von Shopware selbst ausgeliefert – keine externen Font-Server)
- **Nova: Layout** – maximale Inhaltsbreite, Eckenradien, Flächenfarbe
- **Nova: Header & Topbar** – Topbar-Farben, maximale Logohöhe, Header beim Runterscrollen ausblenden
- **Nova: Produktlisting** – Bild-Modus, 2 Produkte pro Zeile auf Smartphones
- **Nova: Footer** – Hintergrundfarbe
- **Nova: Checkout & Konto** – Fortschrittsanzeige im Checkout an/aus
- **Nova: Effekte** – dezente Einblend-Animationen

### Konto löschen aktivieren

Die Funktion ist in Shopware eingebaut, aber standardmäßig aus: **Einstellungen → Login & Registrierung → „Kunden können ihr Konto löschen“** aktivieren. Danach erscheint im Profil der Bereich „Konto löschen“ mit Sicherheitsabfrage.

### Absprache mit anderen Plugins (Tracking)

Produktlisten, die das Theme per JavaScript nachlädt (z. B. „Zuletzt angesehen“), sind so ausgezeichnet, dass ein Tag-Manager-Plugin sie erfassen kann:

| Merkmal | Bedeutung |
|---|---|
| `data-nova-list-id` / `data-nova-list-name` am Listen-Container | Listen-ID und -Name, z. B. `recently_viewed` / `Zuletzt angesehen` |
| `data-product-information` an jeder Produktbox | Kommt aus Shopwares Standard-Produktbox (ID, Name, Marke, Preis, Nummer) |
| Event `nova:products-rendered` auf `document` | Wird nach dem Einfügen ausgelöst, `event.detail.container` ist der Listen-Container |

## Mehrere Shops mit eigenen Farben

Theme-Einstellungen gelten pro Theme. Für mehrere Verkaufskanäle mit unterschiedlichen Farben/Logos:

1. **Inhalte → Themes**, beim Nova Theme auf **„…“ → Theme duplizieren**
2. Der Kopie einen Namen geben (z. B. den Shopnamen), Farben und Logo einstellen
3. Die Kopie dem jeweiligen Verkaufskanal zuweisen

Code-Updates des Nova Themes wirken automatisch auf alle Kopien.

## Umstieg von einem anderen Theme

1. Nova Theme installieren (siehe oben) – **noch nicht zuweisen**
2. Für jeden Shop eine Theme-Kopie anlegen, Farben, Logo und Favicon übernehmen
3. Plugin-Konfiguration je Verkaufskanal ausfüllen (Topbar-Text etc.)
4. Zuerst in einem Test-Verkaufskanal bzw. Staging prüfen, dann umstellen
5. `bin/console theme:compile && bin/console cache:clear`
6. Erst danach das alte Theme deaktivieren und deinstallieren

## Struktur

```
src/
├── NovaTheme.php                      Plugin-Klasse (ThemeInterface)
└── Resources/
    ├── theme.json                     Theme-Definition & Konfigurationsfelder
    ├── views/storefront/
    │   ├── base.html.twig             Body-Klassen aus Theme- & Plugin-Konfiguration
    │   ├── layout/header/top-bar.html.twig   Topbar
    │   ├── component/product/listing.html.twig   Artikelzähler
    │   ├── page/checkout/_page.html.twig    Fortschrittsanzeige im Checkout
    │   ├── page/checkout/cart/index.html.twig   „Zuletzt angesehen“ im Warenkorb
    │   ├── page/content/product-detail.html.twig   „Zuletzt angesehen“ auf der Produktseite
    │   ├── page/account/profile/index.html.twig   Bereich „Konto löschen“
    │   └── nova/                        Templates für „Zuletzt angesehen“
    ├── config/routes.xml, services.xml   Route /nova/recently-viewed
    ├── config/config.xml              Plugin-Einstellungen pro Verkaufskanal
    ├── snippet/                       Textbausteine (de-DE, en-GB)
    └── app/storefront/
        ├── src/
        │   ├── main.js                Registriert JS-Plugins (Lazy-Import)
        │   ├── plugin/                Kompakter Header, Ladebalken, Konfetti, Einblend-Animation, Zuletzt angesehen
        │   └── scss/
        │       ├── overrides.scss     Bootstrap-/Shopware-Variablen (vor dem Kern)
        │       ├── base.scss          Einstiegspunkt – Module ein-/ausschalten
        │       ├── abstracts/         Variablen, Mixins, nova-fluid()
        │       ├── base/              Tokens, Typografie
        │       ├── layout/            Container, Header, Navigation, Footer
        │       ├── components/        Buttons, Formulare, Produktkarte, PDP, CMS, Offcanvas, Warenkorb-Positionen, Produkt-Slider
│       ├── pages/             Checkout, Kundenkonto
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

- Shopware 6.6.x und 6.7.x (getestet gegen die Templates von 6.7.15)
- Alle aktuellen Browser (Container Queries ab Chrome 105, Safari 16, Firefox 110)

## Lizenz

MIT
