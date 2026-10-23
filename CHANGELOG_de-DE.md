# 1.5.5
- Neu: Erlebniswelt-Baustein `nova-prose` – längerer Fließtext in angenehmer Lesebreite
- `nova-split` auch für „Drei Spalten, Bild & Text“ (Bild – Text – Bild)

# 1.5.4
- Erlebniswelt-Bausteine: Vorteils-Leiste (`nova-trust`) flacher und je Spalte mittig, mehr Abstand vor `nova-lead`, `nova-split` und `nova-band`, Links in `nova-cards` sitzen in allen Karten auf gleicher Höhe unten

# 1.5.3
- Smartphone/Tablet: keine leere Navigationsleiste mit Doppellinie mehr unter dem Header
- Dunkler Footer auf dem Smartphone: Trennlinien und Plus/Minus der aufklappbaren Spalten passend hell

# 1.5.2
- Schwebender kompakter Header: Ist die Suche ausgeblendet, ist die Leiste nur so breit wie ihr Inhalt (Menü und Button/Symbole) statt einer großen leeren Fläche

# 1.5.1
- Footer: leere Logo-Leiste (ohne Zahlungs-/Versandlogos) wird ausgeblendet; bei dunklem Footer ist die Copyright-Zeile dunkel statt hellgrau und damit lesbar

# 1.5.0
- Neu: Bausteine für Erlebniswelten (CSS-Klasse am Block): `nova-hero` (Startbild mit Verlauf und Buttons), `nova-lead` (zentrierte Einleitung), `nova-trust` (Vorteils-Leiste), `nova-cards` (Bild-Text-Spalten als Karten), `nova-split` (Bild und Text nebeneinander), `nova-band` (farbiges Kontaktband), `nova-accent`
- Neu: Akzentfarbe in der Theme-Konfiguration (Haupt-Button im Startbild), Schriftfarbe automatisch hell oder dunkel
- Neu: Header-Symbole pro Verkaufskanal ausblenden (Suche, Merkzettel, Konto, Warenkorb) – für Infoseiten ohne Shop
- Neu: Button rechts im Header mit eigenem Text und Link (z. B. „Termin anfragen“)
- Neu: Preis-Hinweis im Footer abschaltbar
- Dunkler Footer-Hintergrund: Schrift, Links und Linien werden automatisch hell

# 1.4.7
- Megamenü: „Zur Kategorie …“ und alle Spalten auf einer gemeinsamen linken Kante, Kopfzeile mit Trennlinie, gleichmäßige Zeilenabstände ohne Trennstriche, Hover ohne springenden Einzug
- Bestellungen im Kundenkonto: doppelter Rahmen entfernt

# 1.4.6
- Kundenkonto überarbeitet: Karten mit Innenabstand (Texte kleben nicht mehr an der Linie), einheitliche Kartentitel, keine Karte in der Karte bei „Letzte Bestellung“
- „Änderungen speichern“ als echter Button in der Akzentfarbe statt kaum sichtbarem hellen Button
- Adressen: Karten mit Rahmen in Theme-Optik, Badge „Standard-Adresse“ in der Akzentfarbe statt Blau
- Überschriften im Kundenkonto auf allen Seiten gleich groß (z. B. „Adressen“)
- Konto-Dropdown im Header im selben Stil wie das Konto-Menü, „Abmelden“ ohne Unterstreichung

# 1.4.5
- Kundenkonto: Seitenüberschrift schließt oben bündig mit dem Konto-Menü ab

# 1.4.4
- Konto-Menü neu gestaltet: eine ruhige Karte mit Begrüßung als Kopf, Einträge ohne eigene Kästen, aktiver Eintrag mit Akzentstrich, „Abmelden“ abgesetzt im Fuß; auf dem Desktop bleibt das Menü beim Scrollen sichtbar

# 1.4.3
- Newsletter-Leiste und Kasten auf der Bestellabschlussseite: Nach erfolgreichem Absenden wird das Formular ausgeblendet und nur noch die Bestätigung gezeigt; bei Fehlern bleibt es stehen

# 1.4.2
- Checkboxen und Radio-Buttons haben einen deutlich sichtbaren Rand, auch auf getönten Flächen
- Datenschutz-Text in der Newsletter-Leiste in derselben kleinen Schriftgröße wie die übrigen Hinweise

# 1.4.1
- Neu: Newsletter-Anmeldung im Bestellprozess wahlweise als Kasten auf der Bestellabschlussseite (nach der Bestellung, ein Klick, eigene Überschrift – Standard) oder als Häkchen in der Bestellübersicht
- Newsletter-Leiste erscheint jetzt auch auf der Anmeldeseite und im Kundenkonto (weiterhin nicht in den Checkout-Schritten nach dem Warenkorb)

# 1.4.0
- Neu: Newsletter-Leiste über dem Footer (pro Verkaufskanal) mit Überschrift, Text und Kleingedrucktem – nutzt Shopwares eigene Newsletter-Anmeldung mit Double-Opt-in, Captcha und Datenschutz-Hinweis; nicht im Checkout und im Kundenkonto
- Neu: Newsletter-Häkchen in der Bestellübersicht – nicht vorausgewählt, erscheint nur, wenn die E-Mail noch nicht angemeldet ist; meldet die Bestell-E-Mail über Shopwares Newsletter-Anmeldung an. Ein Fehler dabei bricht die Bestellung nie ab

# 1.3.1
- Behoben: Bildformat und Bild-Modus wirkten nicht, weil Shopwares feste Bildhöhe (180–200 px) Vorrang hatte – Produktbilder füllen jetzt die Karte im gewählten Seitenverhältnis
- Produktkarten kompakter: keine Lücken mehr für leere Bewertungen, fehlende „ab“-Preise und Grundpreise; der Warenkorb-Button sitzt unten
- Behoben: Seite war auf dem Smartphone einige Pixel zu breit (horizontales Scrollen), u. a. auf Kategorieseiten mit Seitenleiste
- Keine Lücke mehr zwischen einer Newsletter-Leiste anderer Plugins und dem Footer
- Button „In den Warenkorb“ in schmalen Karten kleiner, damit er nicht umbricht

# 1.3.0
- Neu: Theme-Einstellung „Bildformat der Produktbilder“ – quadratisch, Hochformat 3:4, Buch/Cover 2:3 oder Querformat 4:3 für Produktkarten und Produktseite. Im Hochformat wird das Produktbild auf der Produktseite auf Bildschirmhöhe begrenzt
- Neu: Serifenschrift „Nova Serif“ (Source Serif 4) wird mitgeliefert – für Überschriften `'Nova Serif', Georgia, serif` eintragen
- Produktnamen in Karten werden nicht mehr mitten im Wort umgebrochen

# 1.2.0
- Neu: Kompakter Header „schwebend“ – abgerundete Leiste mittig mit Menü, Suche, Merkzettel, Konto und Warenkorb (Standard); alternativ wie bisher volle Breite mit Logo (Theme-Einstellung „Aussehen des kompakten Headers“)

# 1.1.0
- Neu: Copyright-Hinweis im Footer pro Verkaufskanal beibehalten, durch eigenen Text ersetzen (`{year}`, `{shop}`, übersetzbar über den Textbaustein `novaTheme.footer.copyright`) oder ausblenden

# 1.0.0
- Erste Version: modernes, modulares und schnelles Theme für Shopware 6.6 und 6.7
- Topbar, kompakter Header beim Scrollen, Ladebalken, Artikelzähler, Konfetti nach der Bestellung
- Modernes Design für Warenkorb, Checkout (Schrittanzeige, Auswahlkarten für Versand und Zahlung), Login und Kundenkonto
- Gut sichtbarer Bereich „Konto löschen“ (Shopware-Einstellung „Kunden dürfen ihr Konto löschen“ erforderlich)
- „Zuletzt angesehen“ als Slider unten auf der Seite – nur mit Zustimmung im Cookie-Dialog
- Gestaltung für das Plugin „Dynamische Monats-Lieferzeiten“
