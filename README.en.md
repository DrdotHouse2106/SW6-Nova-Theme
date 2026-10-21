# Nova Theme for Shopware 6

🇩🇪 [Deutsche Version](README.md)

Modern, modular and **fast** storefront theme for Shopware 6.6 and 6.7 – optimised for every screen size, from smartphone to 4K.

## Highlights

- **Performance:** system font stack (no web font download), only ~2 KB of custom JavaScript, plugins loaded on demand via dynamic import, `content-visibility` for the footer, fixed image aspect ratios to avoid layout shift (CLS)
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

## Development

Inside Shopware: `bin/build-storefront.sh` / `bin/watch-storefront.sh`.
Standalone JS build: `cd src/Resources/app/storefront && npm install && npm run build`.

## CMS helper classes

`nova-surface`, `nova-section`, `nova-rounded`, `nova-shadow` – add them via the "CSS class" field of CMS sections/blocks. Add `data-nova-reveal` to any element for the reveal animation.

## Compatibility

Shopware 6.6.x and 6.7.x · all current browsers.

## License

MIT
