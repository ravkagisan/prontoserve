# Repository instructions

## Project summary

- This is a server-rendered PHP marketing website for JTI NOVA.
- The site has no framework, package manifest, database, build system, or automated test suite.
- Deployment is configured for Vercel PHP (`vercel-php@0.7.2`) by `vercel.json`.
- User-facing text is primarily Indonesian (`lang="id"`).

## Repository layout

- `Pages/` contains top-level and detail pages. Detail pages usually live in nested `Detail/` directories.
- `Components/` contains shared PHP renderers and their component-specific CSS:
  - `button.php`, `card.php`, `carousel.php`, `ctacontainer.php`, `navbar.php`, `footer.php`
- `Style/style.css` contains global design tokens and shared base styles.
- `Assets/images/` contains local images.
- `api/index.php` is the local/Vercel request router.
- `error/index.php` and `Pages/Error/index.php` provide error pages.
- `vercel.json` defines static assets, API routing, and the 404 fallback.

## PHP conventions

- Keep pages dependency-free and server-rendered. Do not introduce Composer, a framework, or a database unless the task explicitly requires it.
- Put page setup data and request handling near the top, before the HTML document.
- Set `$current_page` for each page and keep the existing page keys used by navigation and footers.
- Compute `$base_url` from `$_SERVER['SCRIPT_NAME']`; preserve the existing fallback and `__DIR__` patterns so the site works from a subdirectory and on Vercel.
- Build links and component paths from `$base_url` or absolute `__DIR__` paths. Do not hard-code repository paths or assume the site is mounted at `/`.
- Include shared files with `require_once` or `include_once` based on whether re-execution must be prevented.
- Share rendering through existing functions such as `render_button()`, `render_card()`, `render_cta()`, and the navbar/carousel/footer components. Do not duplicate component markup or CSS locally.
- Page data currently consists of PHP arrays; keep data near the page that owns it unless it is genuinely shared.
- Preserve query-string behavior for detail pages (for example, `?id=`) and return redirects or the first valid item when an ID is invalid, matching existing detail-page patterns.
- Escape dynamic HTML and attributes with `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` or a context-appropriate integer cast. Encode dynamic JavaScript data safely with `json_encode()` and the existing HEX options.
- Validate and normalize request input before use. Never output unescaped `$_GET`, `$_POST`, server, or session values.
- Existing form behavior redirects to WhatsApp and does not perform server-side persistence. Do not invent a backend or silently change that behavior unless explicitly requested.

## HTML, CSS, accessibility

- Keep the visual language, language, and naming consistent:
  - Indonesian labels and copy
  - Inter font
  - existing brand and spacing variables
  - lowercase, hyphenated BEM-like component classes
- Use `Style/style.css` for global tokens and base styles. Add or change component CSS in the relevant component or page so it remains local.
- Reuse CSS custom properties for colors, spacing, radii, and shadows instead of introducing equivalent hard-coded values.
- Preserve responsive behavior and existing media queries. Check desktop and mobile layouts for any visible layout change.
- Keep semantic landmarks and navigation structure: `<header>/<nav>`, `<main>`, `<section>`, and `<footer>` where appropriate.
- Preserve keyboard and screen-reader behavior: visible `:focus-visible` styles, labels for inputs, sensible alt text, and `aria-*` attributes for interactive controls.
- Respect `prefers-reduced-motion: reduce`; do not add motion that bypasses existing reduced-motion handling.

## Assets and routing

- Prefer existing files in `Assets/images/` and use the existing image fallback behavior.
- Remote Unsplash, Google Fonts, and Google Maps resources are already used; do not replace or remove them without a related requirement.
- Preserve Vercel routes and static asset paths. A route change in `vercel.json` must also account for `/Pages/...`, `/api/...`, static assets, and the 404 fallback.
- When adding a page, place it under `Pages/` and follow the same `current_page`, `$base_url`, navbar, footer, and CTA patterns.

## Editing guidance

- Make surgical changes and preserve unrelated or in-progress user edits.
- Before changing a shared component, inspect every caller and preserve its public array/options interface.
- Avoid moving inline CSS or JavaScript unless the task specifically asks for restructuring.
- Do not add placeholders or Lorem ipsum as a substitute for requested content unless the existing page already uses placeholder copy.
- Do not change branding, statistics, contact details, or navigation as incidental cleanup.

## Validation

There is no test runner. At minimum, validate PHP syntax across the repository:

```bash
find . -type f -name '*.php' -exec php -l {} \;
```

For route or rendering changes, start PHP locally with the API router and exercise affected URLs:

```bash
php -S 127.0.0.1:8000 api/index.php
```

At minimum check:

- `/`
- `/Pages/index.php`
- the changed page
- nested detail URLs and their `?id=` values
- `/api/...` behavior
- an unknown route or `/404`
- desktop and mobile rendering

When PHP or browser tooling is unavailable, clearly state the validation limitation rather than claiming the change was tested.
