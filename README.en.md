# Nova Theme for Shopware 6

🇩🇪 [Deutsche Version](README.md)

Modern, modular and **fast** storefront theme for Shopware 6.6 and 6.7 – optimised for every screen size, from smartphone to 4K.

## Highlights

- **Performance:** no external fonts or scripts, only ~7 KB of custom JavaScript, plugins loaded on demand via dynamic import, `content-visibility` for the footer, fixed image aspect ratios to avoid layout shift (CLS)
- **Responsive:** mobile first, fluid typography and spacing with `clamp()`, **container queries** for product cards, two-column listing on phones, 44–48 px touch targets
- **Modular:** every SCSS module lives in its own file and can be disabled in `base.scss`; design tokens exposed as CSS custom properties (`--nova-*`)
- **Configurable:** colours, fonts, radii, content width, sticky/auto-hide header and animations in the administration
- **Accessible:** visible focus rings, respects `prefers-reduced-motion`, hover effects only on pointer devices

## Installation

```bash
cd <shopware-root>/custom/plugins
git clone https://github.com/DrdotHouse2106/sw6-theme.git NovaTheme
cd <shopware-root>
bin/console plugin:refresh
bin/console plugin:install --activate NovaTheme
bin/console theme:change NovaTheme --all
bin/console cache:clear
```

## Features

Modern cart, checkout (progress indicator, shipping/payment selection cards, sticky summary) and customer account, a clearly visible "delete account" section (enable it under *Settings → Login & registration*), a "recently viewed" slider on product and cart pages (stored only in the browser), top bar (info text, phone, e-mail, opening hours), compact header while scrolling (floating rounded bar or full width with logo, no layout shift, optional auto-hide), page loading bar, product count above listings, confetti after a successful order, footer copyright notice (keep, replace with own text incl. `{year}`/`{shop}` or hide – per sales channel), image mode (contain/cover), image format (1:1, 3:4 portrait, 2:3 book/cover, 4:3 landscape – for product cards and product page), bundled serif font "Nova Serif" (Source Serif 4, OFL; set the headline font to `'Nova Serif', Georgia, serif`), 2 products per row on phones, building blocks for shopping experiences (`nova-hero`, `nova-lead`, `nova-trust`, `nova-cards`, `nova-split`, `nova-band`, `nova-accent`, `nova-steps` numbered steps (`nova-steps-plain` without numbers), `nova-form` form as card, `nova-fitment` modern fitment table, `nova-chips` links as round selection buttons, e.g. vehicle models), hide header icons and header button for information sites, accent colour, automatic light text on a dark footer, newsletter bar above the footer and newsletter registration in the checkout as a box on the order finish page or a checkbox on the order confirmation page (both use Shopware's own newsletter registration with double opt-in).

Per-sales-channel settings: *Extensions → My extensions → Nova Theme → Configure*. Colours and layout: *Content → Themes*. For several shops with different colours, duplicate the theme once per sales channel.

## Product page

From 1.13.0 the theme extends the "Description & reviews" element with tabs: **Description · Reviews · Manufacturer information · Questions about the product** (each part can be switched off per sales channel under *Configure → Product page*, default on).

- **Reviews** only if there are reviews; otherwise the description ends with a "Write a review" link that expands the review form.
- **Manufacturer information (GPSR):** custom field set "Manufacturer information (GPSR)" on manufacturers (`nova_gpsr_company`, `nova_gpsr_street`, `nova_gpsr_zipcode_city`, `nova_gpsr_country`, `nova_gpsr_email`, `nova_gpsr_phone`, `nova_gpsr_website`, `nova_gpsr_eu_name`, `nova_gpsr_eu_address`, `nova_gpsr_eu_email`, `nova_gpsr_safety_info`) and "Product safety (GPSR)" on products (`nova_gpsr_product_safety_info`), created on install/update. Empty manufacturer fields fall back to the manufacturer description.
- **Questions about the product:** the first contact form of the product page layout is shown in the tab with prefilled subject and item number. The form element stays in the layout (recipient, Nova Upload, captcha keep working); a block that only contains the form is hidden in its original place – put the form in its own form block.
- **Cross-selling:** one group → its name as heading; several groups → tabs; "Customers also bought" (Nova Search) gets a visible heading. Sliders with vertical alignment no longer render squeezed on first load.
- On phones description, reviews and manufacturer information open in the off-canvas; the questions tab expands below the tab list.

## Recently viewed and delivery dates

"Recently viewed" is shown as a slider at the bottom of every page above the footer (not in checkout after the cart and not in the customer account), only with consent (comfort features). Page types are configurable. The theme also styles the "Dynamic monthly delivery dates" plugin (product page info box, line items, listing, checkout summary).

## Development

Inside Shopware: `bin/build-storefront.sh` / `bin/watch-storefront.sh`.
Standalone JS build: `cd src/Resources/app/storefront && npm install && npm run build`.

## CMS helper classes

`nova-surface`, `nova-section`, `nova-rounded`, `nova-shadow` – add them via the "CSS class" field of CMS sections/blocks. Add `data-nova-reveal` to any element for the reveal animation.

## Compatibility

Shopware 6.6.10+ and 6.7.x · all current browsers.

## Legal texts for several shops

Moved to the separate plugin [Nova Legal Texts](https://github.com/DrdotHouse2106/SW6-Nova-Rechtstexte) in 1.11.0.

## Troubleshooting

Known pitfalls from real installations. **Please add new ones** (or open an issue).

- **White text on yellow buttons:** fixed in 1.9.5 for accent buttons; set the buy button text colour yourself in the theme.
- **SVG logo stays small:** from 1.9.6 the configured logo height is used exactly; separate field for phone & tablet.
- **No visible change:** run `bin/console theme:compile` and `cache:clear`.
- **Only one shop uses the theme:** themes are assigned per sales channel – duplicate the theme per shop.
- **Top bar missing:** enable it in the plugin configuration per sales channel; hidden below 992 px.
- **No "delete account" button:** enable *Settings → Login & registration → customers may delete their account*.
- **"Recently viewed" missing:** requires consent ("comfort features"), stored in the browser only, not shown in checkout/account.
- **Product page: form missing or shown twice:** the theme uses the first contact form of the layout; put it in its own form block (blocks with other elements stay without the form).
- **File attachments in the contact form:** moved to the plugin **Nova Upload** in 1.8.0 (protected storage, product uploads).

## How this plugin was made

This plugin was developed with the help of AI (Claude by Anthropic). The requirements come from running several Shopware shops day to day; the code was written and revised with AI. It is checked with automated tests and static analysis (where present in the repository), regular security reviews of the code and in production use in the author's own shops. Still: use at your own risk and without warranty (see license). Please report bugs and suggestions as an issue. More background: [SW6-Nova-Plugins](https://github.com/DrdotHouse2106/SW6-Nova-Plugins).

## License

MIT
