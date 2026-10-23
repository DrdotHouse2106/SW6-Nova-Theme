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
| **Kompakter Header** | Sobald der Header aus dem Bild gescrollt ist, erscheint eine schmale Leiste mit Menü, Suche, Merkzettel, Konto und Warenkorb – ohne dass der Inhalt springt. Aussehen wählbar: **schwebend** (abgerundete Leiste mittig, Standard) oder **volle Breite mit Logo**. Optional beim Runterscrollen ausblenden |
| **Ladebalken** | Schmaler Fortschrittsbalken beim Klick auf interne Links |
| **Artikelzähler** | „2126 Artikel“ über dem Listing, aktualisiert sich beim Filtern |
| **Konfetti** | Kurze Animation nach erfolgreicher Bestellung (ohne externe Bibliothek) |
| **Produktbilder** | Wahlweise ganz zeigen (freigestellt) oder Fläche füllen (Fotos). **Bildformat** quadratisch, Hochformat 3:4, Buch/Cover 2:3 oder Querformat 4:3 – gilt für Produktkarten und Produktseite; im Hochformat wird das Bild auf der Produktseite auf Bildschirmhöhe begrenzt statt über die volle Spaltenbreite aufgeblasen |
| **Serifenschrift** | „Nova Serif“ (Source Serif 4, SIL Open Font License) wird mit dem Theme ausgeliefert – ohne externen Font-Server und nur geladen, wenn sie eingestellt ist. Ideal für Überschriften in Verlags-, Buch- oder Manufaktur-Shops |
| **Dynamische Lieferzeiten** | Passende Gestaltung für das Plugin „Dynamische Monats-Lieferzeiten“: Infobox mit Kalender-Symbol auf der Produktseite, kompakte Zeile an Warenkorb-Positionen, kurze Zeile im Listing, Termin-Übersicht in Bestellprüfung und Abschluss. Ohne das Plugin wirkungslos |
| **Zuletzt angesehen** | Slider unten auf jeder Seite direkt über dem Footer (nicht im Checkout ab der Adresseingabe und nicht im Kundenkonto), auf der Produktseite ohne das aktuelle Produkt. Seitentypen in der Plugin-Konfiguration wählbar. Nur mit Zustimmung im Cookie-Dialog („Komfortfunktionen“), beim Widerruf wird die Liste sofort gelöscht. Die Liste liegt nur im Browser des Kunden (localStorage, max. 20 Produkte) – auf dem Server wird nichts gespeichert |
| **Modernes Checkout** | Fortschrittsanzeige (Warenkorb → Adresse → Prüfen → Fertig), Versand- und Zahlungsarten als Auswahlkarten, mitlaufende Zusammenfassung auf dem Desktop, Bestell-Button auf dem Smartphone immer sichtbar, schlanker Checkout-Header |
| **Modernes Kundenkonto** | Konto-Menü als Karte, Karten für Übersicht, Profil, Adressen und Bestellungen, Login und Registrierung mit großen Eingabefeldern |
| **Konto löschen** | Gut sichtbarer Bereich „Konto löschen“ im Profil mit Sicherheitsabfrage |
| **Newsletter** | Leiste über dem Footer (Überschrift, Text, Kleingedrucktes, pro Verkaufskanal) und Anmeldung im Bestellprozess – als Kasten auf der Bestellabschlussseite (ein Klick, die Bestell-E-Mail ist schon eingesetzt) oder als Häkchen in der Bestellübersicht. Beides nutzt Shopwares eigene Newsletter-Anmeldung – Double-Opt-in, Captcha und Datenschutz-Hinweis wie in Shopware eingestellt, angemeldete Empfänger stehen unter *Marketing → Newsletter-Empfänger*. Kasten bzw. Häkchen erscheinen nur, wenn die E-Mail noch nicht angemeldet ist; das Häkchen ist nie vorausgewählt |
| **Copyright im Footer** | „Realisiert mit Shopware“ beibehalten, durch eigenen Text ersetzen (mit `{year}` und `{shop}`, pro Sprache übersetzbar) oder ausblenden – pro Verkaufskanal |

## Einstellungen

### Plugin-Konfiguration (pro Verkaufskanal)

**Erweiterungen → Meine Erweiterungen → Nova Theme → Konfigurieren** – oben den Verkaufskanal wählen:

- **Topbar** – an/aus, Infotext, Link, Telefon, E-Mail, Öffnungszeiten
- **Header** – kompakter Header beim Scrollen, Ladebalken, Header-Symbole ausblenden (Suche, Merkzettel, Konto, Warenkorb – für Infoseiten ohne Shop), Header-Button mit Text und Link (z. B. „Termin anfragen“ → `/Kontakt/`)
- **Produktlisting** – Artikelanzahl anzeigen
- **Zuletzt angesehen** – Liste an/aus und auf welchen Seiten (leer = alle außer Checkout und Kundenkonto)
- **Footer** – Copyright-Hinweis: Shopware-Standard, eigener Text oder ausblenden.
  Eigener Text z. B. `© {year} {shop} – Alle Rechte vorbehalten` (`{year}` = aktuelles Jahr,
  `{shop}` = Shopname). Feld leer lassen, um den Text pro Sprache über den Textbaustein
  `novaTheme.footer.copyright` (*Einstellungen → Textbausteine*) zu pflegen.
  Shopware steht unter MIT-Lizenz, der Hinweis darf entfernt werden.
  Außerdem: Preis-Hinweis „Alle Preise inkl. MwSt. …“ ausblenden – für Infoseiten ohne Verkauf.
- **Newsletter** – Leiste über dem Footer an/aus, Überschrift, Text (einfaches HTML), Kleingedrucktes; Anmeldung im Bestellprozess an/aus, Position (Bestellabschlussseite oder Bestellübersicht), Überschrift und Text. Leere Felder nutzen die Textbausteine `novaTheme.newsletter.*` (pro Sprache übersetzbar)
- **Checkout** – Konfetti nach der Bestellung

### Theme-Konfiguration (Farben & Layout)

**Inhalte → Themes → Nova Theme**:

- **Theme-Farben / Typografie** – Primär-, Sekundär-, Kauf-Button-Farbe, Schriftart (Standard: Inter, wird von Shopware selbst ausgeliefert – keine externen Font-Server). Für Überschriften mit Serifen bei *Schriftart Überschriften* eintragen: `'Nova Serif', Georgia, serif`
- **Nova: Layout** – maximale Inhaltsbreite, Eckenradien, Flächenfarbe
- **Nova: Header & Topbar** – Topbar-Farben, maximale Logohöhe, Header beim Runterscrollen ausblenden
- **Nova: Produktlisting** – Bild-Modus, Bildformat (1:1, 3:4, 2:3, 4:3), 2 Produkte pro Zeile auf Smartphones
- **Nova: Footer** – Hintergrundfarbe; bei dunkler Farbe werden Schrift, Links und Linien automatisch hell
- **Theme-Farben** – zusätzlich **Akzentfarbe** für den Haupt-Button im Startbild (`nova-hero`)
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
    │   ├── base.html.twig             Body-Klassen; „Zuletzt angesehen“ über dem Footer jeder Seite
    │   ├── layout/header/top-bar.html.twig   Topbar
    │   ├── component/product/listing.html.twig   Artikelzähler
    │   ├── page/checkout/_page.html.twig    Fortschrittsanzeige im Checkout
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
        │       ├── components/        Buttons, Formulare, Produktkarte, PDP, CMS, Offcanvas, Warenkorb-Positionen, Produkt-Slider, Lieferzeiten
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
| `nova-hero` | **Startbild:** Block (z. B. „Text“) mit Hintergrundbild in einem Abschnitt mit voller Breite. Text hell auf dunklem Verlauf, Überschrift groß. Buttons aus dem Texteditor: „Primär“ = Akzentfarbe, „Sekundär“ = weißer Rahmen |
| `nova-lead` | Zentrierte Einleitung (Überschrift + Text) über einem Bereich |
| `nova-trust` | Schmale weiße Leiste mit kurzen Vorteilen (Block mit 2–3 Text-Spalten) |
| `nova-cards` | Spalten mit Bild und Text als Karten mit gemeinsamem Schatten, Bilder einheitlich 4:3 (z. B. „Drei Spalten, Bild & Text“) |
| `nova-split` | Bild und Text nebeneinander, Bild mit runden Ecken, Text vertikal mittig („Bild & Text“) |
| `nova-band` | Band in der Primärfarbe mit heller Schrift und runden Ecken – z. B. Kontakt oder Hinweis |
| `nova-accent` | Hintergrund in der Akzentfarbe, Schriftfarbe automatisch |
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

## Häufige Probleme und Lösungen

Hier sammeln wir Hürden, die bei Installation und Betrieb tatsächlich aufgetreten sind. **Neue Probleme bitte ergänzen** (oder als Issue melden), damit andere nicht lange suchen müssen.

### Nach Installation/Update keine Änderung im Shop

**Ursache:** Theme nicht neu kompiliert oder Cache

**Lösung:** `bin/console theme:compile` und `bin/console cache:clear` (oder in der Administration: Theme speichern)

### Nur ein Shop sieht das Theme

**Ursache:** Themes werden **pro Verkaufskanal** zugewiesen

**Lösung:** *Inhalte → Themes → Nova Theme → „…“ → Theme duplizieren* und die Kopie dem jeweiligen Verkaufskanal zuweisen – so bekommt jeder Shop eigene Farben/Logo

### Topbar erscheint nicht

**Ursache:** Topbar ist in der **Plugin-Konfiguration** pro Verkaufskanal aus, oder Bildschirm schmaler als 992 px

**Lösung:** *Erweiterungen → Nova Theme → Konfigurieren* → oben Verkaufskanal wählen → Topbar aktivieren und Text eintragen. Auf Smartphones wird die Topbar bewusst ausgeblendet

### Kein Button „Konto löschen“

**Ursache:** Shopware-Einstellung ist aus

**Lösung:** *Einstellungen → Login & Registrierung → „Kunden dürfen ihr Konto löschen“* aktivieren

### „Zuletzt angesehen“ erscheint nicht

**Ursache:** Nur mit Zustimmung im Cookie-Dialog („Komfortfunktionen“), erst nachdem Produktseiten besucht wurden; nicht im Checkout und nicht im Kundenkonto

**Lösung:** Cookie-Einstellungen öffnen, „Zuletzt angesehene Produkte“ erlauben, ein Produkt ansehen. Seitentypen in der Plugin-Konfiguration prüfen

### „Zuletzt angesehen“ ist leer, obwohl Produkte angesehen wurden

**Ursache:** Die Liste liegt im **Browser** (localStorage) – anderer Browser/Gerät oder privater Modus

**Lösung:** Gewolltes Verhalten (es wird nichts auf dem Server gespeichert)

### Schrift sieht anders aus als vorher

**Ursache:** Standard ist die Schrift **Inter**, die Shopware selbst ausliefert

**Lösung:** In der Theme-Konfiguration unter Typografie eine andere Schrift eintragen

### Logo zu groß/zu klein

**Ursache:** Logohöhe ist begrenzt

**Lösung:** Theme-Konfiguration → „Nova: Header & Topbar“ → maximale Logohöhe

### Lieferzeiten-Hinweise ohne Gestaltung

**Ursache:** Styles greifen nur mit dem Plugin „Dynamische Monats-Lieferzeiten“ (ab 2.0.0)

**Lösung:** Plugin installieren; danach `theme:compile`

### Startbild (`nova-hero`): Text klebt am linken Rand oder Bild fehlt

**Ursache:** Der Block liegt in einem Abschnitt mit Inhaltsbreite, oder das Bild ist als Bild-Element statt als Hintergrundbild des Blocks gesetzt

**Lösung:** Abschnitt auf „Volle Breite“ stellen und das Bild im Block unter *Einstellungen → Hintergrundbild* (Modus „Ausfüllen“) eintragen. Der Text richtet sich automatisch an der Inhaltsbreite aus

### Newsletter-Anmeldung erscheint doppelt

**Ursache:** Neben der Nova-Leiste bzw. dem Nova-Häkchen ist noch ein anderes Newsletter-Plugin mit eigener Leiste oder eigenem Häkchen aktiv

**Lösung:** Im anderen Plugin Leiste und Häkchen für den Verkaufskanal ausschalten oder das Plugin deaktivieren. Die Anmeldungen landen in beiden Fällen in Shopwares Newsletter-Empfängern – bestehende Abonnenten und an den Newsletter-Status geknüpfte Rabatte bleiben erhalten

### Nach dem Theme-Wechsel haben einzelne Bereiche noch die alten Farben

**Ursache:** Die Farben stammen nicht aus dem Theme, sondern aus der Konfiguration eines anderen Plugins (z. B. Newsletter-Leiste über dem Footer, Cookie- oder Copyright-Plugins) oder aus eigenem CSS in einer Erlebniswelt

**Lösung:** Im Browser per Rechtsklick → *Untersuchen* die Klasse des Bereichs ansehen (z. B. `footer-main-newsletter`), das zugehörige Plugin unter *Erweiterungen → Meine Erweiterungen → Konfigurieren* öffnen und die Farben dort pro Verkaufskanal anpassen

## Lizenz

MIT
