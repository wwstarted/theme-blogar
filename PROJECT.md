# Blogar Project Documentation

## 1. Project Overview

- Project name: `Blogar`
- Short description: Custom WordPress theme built from the Blogar HTML reference, with a pixel-focused implementation approach.
- Tech stack: WordPress custom theme, PHP, HTML, CSS, JavaScript.

## 2. Folder Structure

- `header.php`
- `footer.php`
- `front-page.php`
- `index.php`
- `functions.php`
- `style.css`
- `/css`
- `/js`
- `/images`
- `/inc`

Current relevant files:

- `/css/header.css`
- `/css/footer.css`
- `/css/frontpage.css`
- `/css/style.css`
- `/js/header.js`
- `/js/footer.js`
- `/js/frontpage.js`
- `/images/logo/logo.png`
- `/images/logo/white-logo.png`
- `/inc/header-setup.php`
- `/inc/footer-setup.php`
- `/inc/theme-setup.php`

## 3. Current Progress

- [x] Header
- [x] Footer
- [x] Homepage
- [ ] Single
- [ ] Archive

## 4. Implemented Details

### Header

- Extracted from the source `index.html`.
- Implemented in `header.php`.
- Implemented styles in `/css/header.css`.
- Implemented interactions in `/js/header.js`.
- Enqueued header assets in `functions.php`.
- Registered `primary` menu in `functions.php`.
- Added fallback menu output so the header still renders before WordPress menus are assigned.
- Added logo support and copied source logo assets into `/images/logo`.
- Includes desktop, tablet, and mobile responsive behavior.
- Includes sticky header behavior.
- Includes mobile off-canvas menu.
- Includes mobile search toggle.
- Includes hover state and active state for navigation.

### Footer

- Extracted from the source `index.html`.
- Implemented in `footer.php`.
- Implemented styles in `/css/footer.css`.
- Enqueued footer assets in `functions.php`.
- Footer layout includes the 6-column link grid, logo/social strip, and copyright row.
- Footer responsive behavior matches the source structure:
- Desktop: 6 columns
- Tablet: 2 columns
- Mobile: stacked single-column layout
- Social icons use hover transitions similar to the source design.
- `wp_footer()` has been added in `footer.php`.
- No footer-specific JavaScript was required for the current source footer layout.

### Homepage

- Extracted from the source `index.html` homepage structure.
- Implemented in `front-page.php`.
- Implemented styles in `/css/frontpage.css`.
- Implemented interactions in `/js/frontpage.js`.
- Homepage assets are enqueued conditionally in `functions.php` only on the front page.
- The page keeps a single `h1` in the hero slider area.
- The layout includes the major homepage sections from the source:
- Hero slider
- Featured posts
- Tabbed content areas
- Post grids and lists
- Video section
- Instagram section
- Source image assets were copied into the theme so the homepage can render with local theme paths.
- Responsive structure follows the original HTML/CSS source, including Bootstrap-like grid behavior and Slick slider styling.

### Single

- Not implemented yet.

### Archive

- Not implemented yet.

## 5. Rules and Conventions

- Only 1 `h1` per page/template.
- Do not hardcode `title` or `meta` tags in templates.
- No inline CSS.
- No inline JavaScript.
- Use `get_template_directory_uri()` for theme assets.
- Split CSS and JS by module: header, footer, frontpage.
- Keep `functions.php` limited to enqueue logic and required configuration.
- Prefer semantic HTML.

## 6. Technical Notes

- The homepage stylesheet currently bundles source CSS from the original theme, including grid, Slick slider, and Font Awesome-related styles needed for pixel matching.
- Some header and footer controls use self-contained markup/icons, while the homepage still relies on source class naming for visual parity.
- Header uses `wp_nav_menu()` for desktop and mobile output.
- Cart count supports WooCommerce when available; otherwise the fallback value is `0`.
- Footer is currently rendered from static structured arrays inside `footer.php` to match the source layout quickly and predictably.
- Homepage markup was generated from the reference HTML and then cleaned to use local theme asset paths.
- Many homepage links still mirror the original demo structure, so content routing may need a later WordPress data integration pass.
- Many main template files are still empty, so the project is still in the foundational build phase.
- Browser-based visual review is still needed to fine-tune any remaining spacing or typography differences.
- `PROJECT.md` must be updated after every completed coding task.

## 7. Next Work Items

- Implement `single.php` when post detail UI work begins.
- Implement `archive.php` when listing/archive UI work begins.
- Review whether logic currently in `functions.php` should later be moved into files inside `/inc`.
