Verified original backup for the 2 homepage sections you pointed out:
- section `blogar-s11p`
- section `s15`

Files included:
- front-page.php
- functions.php
- js/frontpage.js
- css/penci-s11p.css

Verification notes:
- `blogar-s11p` was cross-checked against `backups/s11p-clone-2026-04-22`
  and matches the original structure:
  - no `data-s11p-slider`
  - inline slider script still inside `front-page.php`
  - 3-column flex layout with equal-height columns via `align-items: stretch`
  - no extra UI polish override block at the end of `css/penci-s11p.css`
- `s15` was taken from the pre-assistant snapshot because the older
  `s11p-clone-2026-04-22` backup predates section `s15`.
  The original `s15` state here has:
  - markup rendered in `front-page.php`
  - styling still inside `css/penci-s11p.css`
  - JS handled by the existing extra `BLOGAR S15` block at the end of `js/frontpage.js`
  - no separate `css/penci-s15.css`
  - no `blogar-penci-s15` enqueue in `functions.php`
