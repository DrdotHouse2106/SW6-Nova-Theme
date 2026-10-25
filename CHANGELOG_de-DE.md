# 1.12.3
- Neu: Bei „Header-Symbole ausblenden“ zusätzlich **„Hauptmenü“** – blendet Menüleiste und Menü-Symbol aus, z. B. für Shops mit nur einer Seite

# 1.12.2
- Neu: CSS-Klasse **nova-hero-light** (zusätzlich zu nova-hero) – helles Startbild ohne dunklen Verlauf, dunkle Schrift mittig, z. B. für Kraftpapier- oder helle Hintergründe

# 1.12.1
- Datenschutz: Die PayPal-Verfügbarkeitsprüfung (SwagPayPal „Funding Eligibility“) lädt das PayPal-Skript nur noch im Bestellvorgang und im Kundenkonto statt auf jeder Seite – vorher ging schon beim Öffnen der Startseite eine Anfrage an paypal.com, auch ohne Einwilligung. Abschaltbar unter *Datenschutz → PayPal-Prüfung nur im Checkout*

# 1.12.0
- Neu: **Hinweis zur Prüfung der Bewertungen** über der Bewertungsliste (§ 5b Abs. 3 UWG). Standardtext: „Bewertungen werden vor der Veröffentlichung von uns freigegeben. Ob die Bewertenden das Produkt gekauft haben, prüfen wir nicht.“ Eigener Text bzw. „-“ (kein Hinweis) je Verkaufskanal unter *Bewertungen*

# 1.11.1
- Neu: Link **„Cookie-Einstellungen“** im Footer (unter dem Preis-Hinweis) – öffnet Shopwares Cookie-Einstellungen, damit Besucher ihre Einwilligung jederzeit ändern oder widerrufen können. Shopware selbst zeigt nach dem Schließen des Banners keinen solchen Link. Abschaltbar unter *Footer → Link „Cookie-Einstellungen“ im Footer zeigen*

# 1.11.0
- Die Platzhalter für Rechtstexte (1.10.0/1.10.1) sind in das eigene Plugin **Nova Rechtstexte** umgezogen und hier entfernt. Bitte Nova Rechtstexte installieren, falls Platzhalter genutzt werden

# 1.10.1
- Weitere Platzhalter: `[[Firma]]`, `[[Inhaber]]`, `[[USt-IdNr]]`, `[[Lieferzeit]]` und `[[Versandkosten]]` (mehrzeilig, HTML erlaubt) – für gemeinsame Texte „Impressum“ und „Zahlung und Versand“
- `[[Zusatz1]]`–`[[Zusatz3]]` jetzt mehrzeilig mit HTML

# 1.10.0
- Neu: **Platzhalter in Erlebniswelt-Texten je Verkaufskanal** – z. B. `[[Shopname]]`, `[[E-Mail]]`, `[[Telefon]]`, `[[Domain]]`, `[[Shop-URL]]`, `[[Jahr]]`, `[[Zusatz1]]`–`[[Zusatz3]]`. Damit genügt EIN Layout je Rechtstext (Impressum, Datenschutz, AGB …) für alle Shops. Wirkt serverseitig in jedem Verkaufskanal (auch mit anderem Theme) und in Modalen wie den AGB im Checkout. Werte unter *Nova Theme → Konfigurieren → Rechtstexte* je Verkaufskanal

# 1.9.7
- Footer: Menülinks (Rechtstexte, Infos, Spaltenüberschriften) ohne Unterstreichung, erst beim Darüberfahren – Links im Fließtext (Telefon, Kontaktformular, Versandkosten) bleiben unterstrichen

# 1.9.6
- Logo wird in der eingestellten Höhe gezeigt statt nur begrenzt – SVG-Wortmarken blieben vorher bei ca. 200px Breite hängen und wirkten zu klein. **Hinweis:** Logos anderer Shops können dadurch etwas größer werden; ggf. „Logohöhe (Desktop)“ anpassen
- Neu: **Logohöhe (Handy & Tablet)** – eigene Höhe für kleine Bildschirme (Standard 56px), das Logo wird nie breiter als der Bildschirm

# 1.9.5
- Schriftfarbe auf Akzentfarbe, Buttons und Footer richtet sich nach der wahrgenommenen Helligkeit: auf Gelb (z. B. #F5C400) jetzt dunkle statt weißer Schrift
- `nova-band`: Buttons gut sichtbar (Primär in der Akzentfarbe, Sekundär mit hellem Rahmen) – vorher dunkel auf dunkel
- `nova-hero`: Überschrift trennt lange Wörter mit Trennstrich statt mitten im Wort, am Handy etwas kleiner

# 1.9.4
- `nova-fitment` wirkt auch außerhalb von Erlebniswelt-Blöcken, z. B. in der Fahrzeug-Beschreibung von Nova Fahrzeugauswahl (dort als CSS-Klasse eintragen)

# 1.9.3
- `nova-fitment` kompakter: erste Spalte und Spaltenköpfe brechen um, kleinere Abstände, Zusatzangabe als zweite Zeile (`<small>` in der ersten Spalte, z. B. Baujahr) – breite Tabellen passen auch neben einer Seitenleiste

# 1.9.2
- Neu: Baustein **`nova-fitment`** – Tabellen im Text als moderne Übersicht (Karte, Teilenummern als Knöpfe, am Handy seitlich scrollbar mit stehender erster Spalte)
- Footer: Mit „Spalte mit Logo und Kurztext“ stehen ab Desktop vier Spalten nebeneinander, statt dass die letzte in eine neue Zeile rutscht
- `nova-cards-contain`: Bildfläche weiß statt in Flächenfarbe – Produktfotos mit weißem Hintergrund wirken nicht mehr wie ein Kasten im Kasten

# 1.9.1
- Neu: Theme-Feld **„Footer: Logo (helle Variante, optional)“** – eigenes Logo für einen dunklen Footer. Ohne Angabe wird wie bisher das normale Logo weiß eingefärbt (bei Logos mit Bildzeichen kann das zu einer weißen Fläche werden)

# 1.9.0
- Neu: Baustein **`nova-chips`** – Links im Text erscheinen als runde Auswahl-Knöpfe nebeneinander, z. B. für die Modellauswahl („Welches Modell fahren Sie?“). Auf dem Smartphone drei gleich breite Knöpfe pro Zeile

# 1.8.4
- Smartphone: Header-Button (z. B. „Teil anfragen“) bleibt in der Symbolzeile statt in eine eigene Zeile zu rutschen; der Merkzettel entfällt dort auf schmalen Handys
- Primär-Buttons (z. B. „Anmelden“ im Newsletter) mit Schriftfarbe passend zur Primärfarbe – bei Orange weiß statt schwarz

# 1.8.3
- Neues Plugin-Icon im Nova-Stil (Erweiterungen → Meine Erweiterungen)
- Repository umbenannt in SW6-Nova-Theme – alte Adresse leitet weiter

# 1.8.2
- `nova-steps`: Icons oben im Kasten (Bild am Anfang des Textes), Nummer rückt dann nach rechts

# 1.8.1
- Neu: `nova-steps-plain` – Kästen wie `nova-steps`, aber ohne Nummer (z. B. Materialien)

# 1.8.0
- Datei-Anhänge im Kontaktformular aus dem Theme entfernt – dafür gibt es das Plugin **Nova Upload** (Dateien geschützt im Shop statt als Mail-Anhang, zusätzlich Uploads bei Artikeln)

# 1.7.1
- Neu: Erlebniswelt-Baustein `nova-steps` – nummerierte Schritte („So funktioniert’s“)
- Neu: Erlebniswelt-Baustein `nova-form` – Formular als Karte in Lesebreite

# 1.7.0
- Neu: Datei-Anhänge im Kontaktformular (Plugin-Konfiguration „Kontaktformular“) – Fotos, PDF, Office, ZIP und 3D-/CAD-Dateien hängen direkt an der Kontaktformular-Mail an den Shop, ohne gespeichert zu werden; Anzahl und Größe einstellbar und geprüft

# 1.6.0
- `nova-hero` ohne Hintergrundbild: dunkle Fläche in der Sekundärfarbe mit leichtem Schimmer in der Akzentfarbe
- `nova-hero` auf „Zwei Spalten, zentriertes Bild & Text“: Text links, Bild rechts (z. B. Produkt-Collage)
- Neu: `nova-cards-cta` – letzte Karte ohne Bild in der Akzentfarbe als Aufruf (z. B. „Ihr Teil ist nicht dabei?“)
- Neu: `nova-cards-contain` – Bilder in Karten ganz zeigen statt beschneiden (Produktfotos)

# 1.5.9
- Footer „Service-Hotline“: Links (Telefon, WhatsApp, E-Mail) stehen als normale Links im Text statt als einzelne große Blöcke – die Spalte bleibt kompakt

# 1.5.8
- Erlebniswelt-Bausteine: leere Absätze (oft aus anderen Programmen kopiert) werden entfernt – sie erzeugten z. B. in `nova-cards` große Lücken; kein Zusatzabstand unter dem letzten Absatz einer Karte

# 1.5.7
- Neu: Footer-Spalte mit Logo und Kurztext (Plugin-Konfiguration „Footer“) – auf dunklem Footer wird das Logo hell dargestellt

# 1.5.6
- `nova-hero` reicht auch in einem Abschnitt mit Inhaltsbreite über die volle Fensterbreite – ein eigener Abschnitt „Volle Breite“ ist nicht mehr nötig

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
