# 1.14.2
- Cart, order overview, order details in the account: column “incl. VAT” is now “of which VAT” – it shows the tax amount of the line item, not the unit price (snippet `checkout.cartHeaderTaxIncludeVat`, editable in snippets)

# 1.14.1
- Vehicle offers: sold vehicles get the page title “{name} – sold” instead of the SEO title “… buy”. With price 0 the offer stays omitted from structured data on purpose (search engines reject offers without price)

# 1.14.0
- New: **vehicle offers** for dealers and workshops showing individual vehicles for sale (enquiry instead of order). Custom field set "Vehicle offer" on products (status available/reserved/sold, price addition, model/type, year, first registration, mileage, power, fuel/engine, gearbox, colour, inspection valid until, historic registration, previous owners, location, short description for listings, work done/restoration), created on install and update. When the status is set:
  - Product page: vehicle header above the layout with status, name (H1), price with addition (no price at 0, "Sold" for sold vehicles), data sheet with all filled fields, expandable work done and the buttons *Call*, *WhatsApp* (prefilled message) and *Request a viewing* (jumps to the layout's contact form, subject prefilled); sold vehicles only show "Looking for a similar vehicle? Ask us". Buy box and product name element are omitted
  - Structured data as a vehicle (JSON-LD Product + Car, used condition, year, mileage …, sold = SoldOut)
  - Product cards: status badge, key data "year · km · inspection" and short description instead of the description excerpt, price with addition or "Sold", "Details" instead of "Add to cart"
  - Settings per sales channel under *Configure → Vehicle offers*: on/off, phone (empty = master data or top bar), WhatsApp number, button texts, note below the price
- New: product sliders on the product page no longer show the current product (e.g. "More offers" from a dynamic product group); if nothing is left, the slider is omitted. Switch under *Product page*

# 1.13.2
- Checkout: the card fields of PayPal “credit or debit card” now sit inside the selected payment card instead of below it; field height so that borders are not cut off

# 1.13.1
- Checkout “Review & order”: payment and shipping method are stacked at full width instead of two narrow columns. In the option cards the name is on the left, the logo on the right, price/delivery and extra options below at full width. Nested checkboxes of other plugins (e.g. PayPal “save account for future purchases”) are no longer framed as a card and no longer squeeze the text

# 1.13.0
- New: **product page tabs** in the "Description & reviews" element: *Description · Reviews · Manufacturer information · Questions about the product*. On phones description, reviews and manufacturer information open in the off-canvas as before, "Questions about the product" expands right below the tab list
- New: **"Reviews" tab only if there are reviews** – otherwise the description ends with "There are no reviews for this product yet. *Write a review*", the link expands the review form. After submitting a review the tab is shown with the confirmation
- New: **manufacturer information (GPSR)** – custom field set "Manufacturer information (GPSR)" on manufacturers (company, street, postcode/city, country, email, phone, website, responsible person in the EU with name/address/email, safety information) and "Product safety (GPSR)" on products. Created on install and update. If the manufacturer fields are empty, the tab shows the manufacturer description; without any data the tab is omitted
- New: **"Questions about the product"** – the first contact form of the product page layout is rendered in the tab with prefilled subject ("Question about item 10001 – name") and message (line "Item number: …"). Recipient, Nova Upload and Nova Captcha keep working, the form still posts to Shopware's contact route. A block that only contains this form is no longer shown in its original place
- New: **cross-selling headings** – with exactly one group its name is shown as a heading instead of a single tab, with several groups the tabs stay. "Customers also bought" (Nova Search) gets a visible heading
- Fixed: product sliders with vertical alignment (e.g. "Customers also bought") were only a few pixels wide on first load (squeezed cards, text letter by letter)
- Every part can be switched off per sales channel under *Configure → Product page* (default: on)

# 1.12.5
- Compatibility: `composer.json` now requires Shopware **6.6.10 or newer** or 6.7 (`~6.6.10 || ~6.7.0`). On 6.6.0 to 6.6.9 "recently viewed" returned HTTP 500 (controller without Twig injection) and the list stayed empty; from 6.6.10 Shopware gets Twig from the container itself

# 1.12.4
- Security: top bar link and header button link are only rendered for http(s)://, mailto:, tel: or relative URLs; other schemes such as javascript: are ignored

# 1.12.3
- New: "Hide header icons" can also hide the main menu (bar and menu icon)

# 1.12.2
- New: CSS class nova-hero-light – light hero without dark overlay, dark centred text

# 1.12.1
- Privacy: PayPal funding eligibility script only on checkout/account pages (was loaded from paypal.com on every page)

# 1.12.0
- New: note above product reviews on how they are checked (§ 5b para. 3 UWG), configurable per sales channel

# 1.11.1
- New: "Cookie settings" link in the footer to change or withdraw consent (can be switched off)

# 1.11.0
- Legal text placeholders moved to the separate plugin Nova Legal Texts

# 1.10.1
- More placeholders: [[Firma]], [[Inhaber]], [[USt-IdNr]], [[Lieferzeit]], [[Versandkosten]] (HTML); [[Zusatz1-3]] multi-line HTML

# 1.10.0
- New: placeholders in shopping experience texts per sales channel ([[Shopname]], [[E-Mail]], [[Telefon]], [[Domain]], …) – one legal text layout for all shops

# 1.9.7
- Footer: menu links without underline (underline on hover)

# 1.9.6
- Logo shown at the configured height (SVG wordmarks were stuck at about 200px width)
- New: logo height for phone & tablet

# 1.9.5
- Text colour on accent, buttons and footer now based on perceived brightness (dark text on yellow)
- `nova-band`: buttons visible on the dark band
- `nova-hero`: long words hyphenate instead of breaking mid-word

# 1.9.4
- `nova-fitment` also works outside shopping-experience blocks (e.g. Nova vehicle selector description)

# 1.9.3
- `nova-fitment` more compact (wrapping first column and headers, smaller spacing, `<small>` second line)

# 1.9.2
- New: building block `nova-fitment` (modern fitment table, scrollable on phones)
- Footer: four columns side by side when the logo column is used
- `nova-cards-contain`: white image area

# 1.9.1
- New theme field "Footer: logo (light version, optional)" for dark footers

# 1.9.0
- New: building block `nova-chips` – links in a text block become round selection buttons (e.g. vehicle models); three per row on phones

# 1.8.4
- Smartphone: header button stays in the icon row (wishlist hidden there on narrow phones)
- Primary buttons use a text colour matching the primary colour (white on orange)

# 1.8.3
- New plugin icon in Nova style
- Repository renamed to SW6-Nova-Theme

# 1.8.2
- `nova-steps`: icons at the top of the box (image at the start of the text), the number moves to the right

# 1.8.1
- New: `nova-steps-plain` – boxes like `nova-steps` without numbers

# 1.8.0
- Removed contact form file attachments from the theme – use the plugin **Nova Upload** instead (protected storage instead of mail attachments, plus product uploads)

# 1.7.1
- New: shopping experience block `nova-steps` – numbered steps
- New: shopping experience block `nova-form` – form as a card in reading width

# 1.7.0
- New: file attachments in the contact form (plugin configuration "Contact form") – images, PDF, Office, ZIP and 3D/CAD files are attached to the contact mail to the shop without being stored; number and size configurable and validated

# 1.6.0
- `nova-hero` without background image: dark area in the secondary colour with a subtle accent glow
- `nova-hero` on the two-column image & text block: text left, image right
- New: `nova-cards-cta` – last card without image in the accent colour as call to action
- New: `nova-cards-contain` – show card images entirely instead of cropping (product photos)

# 1.5.9
- Footer "service hotline": links (phone, WhatsApp, e-mail) are shown inline instead of as separate large blocks – the column stays compact

# 1.5.8
- Building blocks: empty paragraphs (often pasted from other programs) are removed – they caused large gaps e.g. in `nova-cards`; no extra space below the last paragraph of a card

# 1.5.7
- New: footer column with logo and short text (plugin configuration "Footer") – the logo is shown light on a dark footer

# 1.5.6
- `nova-hero` spans the full window width even inside a content-width section – no separate full-width section needed

# 1.5.5
- New building block `nova-prose` – longer text in a comfortable reading width
- `nova-split` also for the image – text – image block

# 1.5.4
- Building blocks: flatter, centred `nova-trust`, more space before `nova-lead`, `nova-split` and `nova-band`, links in `nova-cards` aligned at the bottom of every card

# 1.5.3
- Phone/tablet: no empty navigation bar with double line below the header
- Dark footer on phones: dividers and plus/minus of the collapsible columns light

# 1.5.2
- Floating compact header: with the search hidden, the bar is only as wide as its content instead of a large empty area

# 1.5.1
- Footer: empty logo bar is hidden; with a dark footer the copyright row is dark instead of light grey and readable

# 1.5.0
- New: building blocks for shopping experiences (CSS class on the block): `nova-hero`, `nova-lead`, `nova-trust`, `nova-cards`, `nova-split`, `nova-band`, `nova-accent`
- New: accent colour in the theme configuration (main hero button), text colour chosen automatically
- New: hide header icons per sales channel (search, wishlist, account, cart) – for information sites without a shop
- New: button on the right in the header with own text and link
- New: price note in the footer can be hidden
- Dark footer background: text, links and lines automatically light

# 1.4.7
- Mega menu: "To category …" and all columns on one common left edge, header row with divider, even row spacing without separators, hover without jumping indent
- Orders in the customer account: double border removed

# 1.4.6
- Customer account reworked: cards with inner padding, consistent card titles, no nested card for "latest order"
- "Save changes" as a real button in the accent colour
- Addresses: cards in theme style, "default address" badge in the accent colour instead of blue
- Same heading size on all account pages
- Account dropdown in the header styled like the account menu, "Log out" without underline

# 1.4.5
- Customer account: page heading aligns with the top of the account menu

# 1.4.4
- Redesigned account menu: one calm card with greeting as header, entries without separate boxes, active entry with accent bar, "Log out" set apart in the footer; sticky on desktop

# 1.4.3
- Newsletter bar and order finish box: after a successful submit the form is hidden and only the confirmation is shown; on errors it stays visible

# 1.4.2
- Checkboxes and radio buttons have a clearly visible border, also on tinted surfaces
- Privacy text in the newsletter bar uses the same small font size as the other notes

# 1.4.1
- New: newsletter registration in the checkout either as a box on the order finish page (after the order, one click, own headline – default) or as a checkbox on the order confirmation page
- Newsletter bar is now also shown on the login page and in the customer account (still not in the checkout steps after the cart)

# 1.4.0
- New: newsletter bar above the footer (per sales channel) with headline, text and small print – uses Shopware's own newsletter registration with double opt-in, captcha and privacy notice; not shown in checkout and customer account
- New: newsletter checkbox on the order confirmation page – not pre-checked, only shown if the e-mail is not subscribed yet; registers the order e-mail via Shopware's newsletter registration. An error never blocks the order

# 1.3.1
- Fixed: image format and image mode had no effect because Shopware's fixed image height (180–200 px) took precedence – product images now fill the card in the chosen aspect ratio
- More compact product cards: no gaps for empty ratings, missing "from" prices and unit prices; the buy button sits at the bottom
- Fixed: page was a few pixels too wide on smartphones (horizontal scrolling), e.g. on category pages with sidebar
- No gap anymore between a newsletter bar of other plugins and the footer
- Smaller "Add to cart" button in narrow cards so it doesn't wrap

# 1.3.0
- New: theme setting "Product image format" – square, portrait 3:4, book/cover 2:3 or landscape 4:3 for product cards and product page. In portrait mode the product page image is limited to the screen height
- New: bundled serif font "Nova Serif" (Source Serif 4) – set the headline font to `'Nova Serif', Georgia, serif`
- Product names in cards no longer break in the middle of a word

# 1.2.0
- New: floating compact header – rounded bar in the centre (default); full-width bar with logo still available (theme setting "Compact header style")

# 1.1.0
- New: footer copyright notice per sales channel – keep, replace with own text (`{year}`, `{shop}`, translatable via snippet `novaTheme.footer.copyright`) or hide

# 1.0.0
- First release: modern, modular and fast theme for Shopware 6.6 and 6.7
- Top bar, compact header while scrolling, loading bar, product count, confetti after ordering
- Modern cart, checkout (progress steps, selection cards), login and account
- Visible "delete account" section (requires the Shopware setting allowing customers to delete their account)
- "Recently viewed" slider at the bottom of the page – only with cookie consent
- Styling for the "Dynamic monthly delivery dates" plugin
