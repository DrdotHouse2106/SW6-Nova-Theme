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
