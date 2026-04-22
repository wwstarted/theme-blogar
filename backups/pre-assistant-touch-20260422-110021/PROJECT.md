# Blogar Theme Project

## 1. Overview

### Summary

`blogar` la custom WordPress theme dang duoc rebuild theo huong clone UI tu bo demo Blogar, nhung runtime frontend da duoc rut gon:

- khong dung `jQuery`
- khong dung `Slick`
- khong dung `Font Awesome`
- thay bang PHP template, CSS thu cong, vanilla JS, SVG inline

Source tham chieu UI van la:

- `C:\My Web Sites\Blogar\new.axilthemes.com\themes\blogar\index.html`

Project khong con chi tap trung vao homepage nua. Hien tai theme da co nhom template noi dung co the render that tren WordPress:

- `front-page.php`
- `archive.php`
- `search.php`
- `single.php`
- `page.php`
- `author.php`

### Current Direction

- Clone sat visual cua source, nhung khong phu thuoc vendor runtime goc.
- Homepage dang duoc chuyen dan sang data-driven render qua `Appearance > Blogar Settings`.
- Nhom template content (`archive`, `search`, `single`, `page`, `author`) da dung du lieu WordPress that.
- Sidebar va widget card layout dang duoc reuse manh giua cac template.

## 2. Current Template Map

### Core templates

- `header.php`
  - Header desktop/mobile, search form, cart badge, off-canvas shell.
- `footer.php`
  - Footer visual clone, data dang hardcode.
- `front-page.php`
  - Homepage 11 section.
- `archive.php`
  - Archive list + sidebar, clone layout list tu source.
- `search.php`
  - Search results, clone structure `archive.php`.
- `single.php`
  - Bai viet chi tiet, TOC, author box, prev/next, related posts, comments.
- `page.php`
  - CMS page layout co hero banner + prose content + sidebar.
- `author.php`
  - Author archive co breadcrumb, author info block, post list + sidebar.
- `index.php`
  - Dang trong, chua dong vai tro fallback thuc te.

### Missing / not implemented yet

- `404.php`
- `comments.php` custom rieng trong theme khong thay ro o root hien tai

## 3. Folder Structure

### Root

- `functions.php`
  - Require `inc/helpers.php` va `inc/theme-options.php`
  - register menu
  - add theme support cho logo + thumbnail
  - register custom image sizes
  - enqueue CSS/JS theo dieu kien template
  - fallback menu
  - helper cart count cho WooCommerce
- `PROJECT.md`
  - Tai lieu hien trang project

### CSS

- `css/style.css`
  - Global tokens, reset, base typography/layout.
- `css/header.css`
  - Header desktop/mobile/sticky/off-canvas.
- `css/footer.css`
  - Footer layout.
- `css/frontpage.css`
  - Homepage visual system va nhieu class shared cho post cards.
- `css/archive.css`
  - Archive/search/list/sidebar styles.
- `css/single.css`
  - Single post content, TOC, author box, related posts, sticky sidebar.
- `css/page.css`
  - Hero banner va page-specific polish cho `page.php`.
- `css/author.css`
  - Author info block cho `author.php`.

### JavaScript

- `js/header.js`
  - Sticky header, mobile menu, mobile search, submenu toggle.
- `js/frontpage.js`
  - Hero slider
  - carousel factory
  - tab switching
  - category carousel
  - copy-link buttons
- `js/footer.js`
  - Dang trong

### Includes

- `inc/helpers.php`
  - Helper dung chung cho thumbnail, alt, reading time, category HTML, share URLs
  - Query/data builder cho homepage sections da dynamic
  - Category thumbnail fallback logic
- `inc/theme-options.php`
  - `Appearance > Blogar Settings`
  - Settings API cho homepage sections da refactor

### Template parts

- `template-parts/archive-sidebar.php`
  - Shared sidebar UI cho archive/search/single theo y do source
  - Hien da ton tai, nhung cac template chinh van chua reuse dong bo 100%

## 4. Asset Loading Reality

`functions.php` dang enqueue theo logic sau:

- Luon load:
  - `css/style.css`
  - `css/header.css`
  - `css/footer.css`
  - `js/header.js`
  - `js/footer.js`
- Load cho `front-page`, `archive`, `search`, `single`, `page`, blog home:
  - `css/frontpage.css`
  - `js/frontpage.js`
- Load them cho `archive`, `search`, `single`, `page`, blog home:
  - `css/archive.css`
- Load them cho `single`, `page`:
  - `css/single.css`
- Load them cho `page`:
  - `css/page.css`
- Load them cho `author`:
  - `css/author.css`

Luu y:

- `author.php` hien tai van phu thuoc visual vao `archive.css`, nhung `functions.php` chi enqueue `author.css` khi `is_author()`.
- Neu `author.css` khong tu import lai archive styles, author page co nguy co thieu style base so voi y do template.

## 5. Template Behavior Map

### Homepage

- `front-page.php`
  - Render 11 section homepage.
  - Mot phan da dynamic qua `theme-options.php` + `helpers.php`.
  - Van reuse rat nhieu class/layout tu source goc.
  - SEO heading hien tai: 1 `h1` o featured post hero, `h2` cho section/sub-group title, post card title dung `h3`, category label o Trending Topics dung `span`, author/meta va footer nav labels khong dung heading.

  Section status hien tai:

  1. Hero Slider
     - Dynamic, admin chon post, helper fallback an toan.
  2. More Featured Posts
     - Chu yeu la hardcode/render tinh.
  3. Banner Ad
     - Visual clone, tinh.
  4. Innovation & Tech
     - Dynamic qua settings + helper.
  5. Trending Topics
     - Dynamic taxonomy carousel.
  6. Most Popular trend list
     - Dynamic tab queries.
  7. Social strip / white card area
     - Static visual block.
  8. Most Popular Grid
     - Dynamic tab + configured posts.
  9. Post List + Sidebar
     - Dynamic query/render.
  10. Featured Video
     - Da chuyen thanh blog-post mode, khong con video popup that.
  11. Instagram
     - Static local mock grid, khong phai live feed.

### Archive

- `archive.php`
  - Dung main WordPress loop.
  - Co breadcrumb + 1 `h1`.
  - Post list layout + sidebar widgets.
  - Layout full-width khong sidebar hien tai dung grid responsive: desktop 3 card / hang, tablet 2 card / hang, mobile 1 card / hang.
  - Outline SEO hien tai: `h1` o breadcrumb, `h2` an cho nhom post, title post dung `h3`; sidebar khong co `h2` an rieng, widget title dung `h2`, title bai nho trong widget dung `h3`, author/meta khong dung heading.
  - Share buttons va copy-link co hoat dong.

### Search

- `search.php`
  - Dung main WordPress search query.
  - Clone gan nhu `archive.php`.
  - 1 `h1` trong breadcrumb area.
  - Outline SEO hien tai: `h1` o breadcrumb, `h2` an cho nhom ket qua, sidebar khong co `h2` an rieng; widget title dung `h2`, title post + title bai nho trong widget dung `h3`, author/meta khong dung heading.
  - Sidebar widget stack giong archive.

### Single

- `single.php`
  - 1 `h1` la post title.
  - Featured image, category, meta, share.
  - Ho tro 2 layout: co sidebar mac dinh hoac no-sidebar centered reading layout thong qua theme option.
  - TOC auto parse tu `h2/h3` trong content, inject sau doan 3.
  - Author box co fallback text.
  - Prev/next post navigation.
  - Comments template.
  - Related posts section full width ben duoi main 2-col layout.
  - Outline SEO hien tai: `h1` cho post title, author/meta khong dung heading, author box/comments/related posts co `h2` section-level; sidebar khong co `h2` an rieng, widget title dung `h2`, con title ben trong dung `h3`.
  - Co inline JS rieng cho TOC toggle + smooth scroll.

### Page

- `page.php`
  - Hero banner lay featured image lam background, fallback anh local neu khong co thumbnail.
  - 1 `h1` trong hero banner.
  - `the_content()` render o cot trai.
  - Outline SEO hien tai: `h1` trong hero, `h2` an cho page content, sidebar khong co `h2` an rieng; widget title dung `h2`, title bai nho trong sidebar dung `h3`.
  - Sidebar dung lai pattern cua single/archive.

### Author

- `author.php`
  - Author archive rieng, khong rely vao `archive.php`.
  - Co breadcrumb + 1 `h1`.
  - Co them author info block: avatar, bio, post count.
  - Outline SEO hien tai: `h1` o breadcrumb, `h2` cho author info + nhom post; sidebar khong co `h2` an rieng, widget title dung `h2`, title bai viet + title bai nho trong sidebar dung `h3`, author/meta khong dung heading.
  - Post list layout clone tu archive.

## 6. Shared Helpers and Patterns

### Helper layer

Nhung helper dang duoc su dung lap lai nhieu:

- `blogar_reading_time()`
- `blogar_post_categories_html()`
- `blogar_thumbnail_url()`
- `blogar_thumbnail_alt()`
- `blogar_social_share_urls()`

Homepage dynamic pattern da duoc chot:

- `inc/theme-options.php`
  - register settings + admin UI
- `inc/helpers.php`
  - doc option + build `WP_Query`/data array
- `front-page.php`
  - chi render

### Carousel / interaction layer

- `js/frontpage.js`
  - `initSlider()`
  - `createCarousel()`
  - `initTabs()`
  - `initCategoryCarousel()`
  - `initCopyLinks()`

Copy-link dang la shared behavior cho:

- homepage
- archive
- search
- single
- page neu co nut copy ve sau

## 7. SEO / Markup Rules Being Followed

Nhung rule dang duoc the hien ro trong source:

- moi template chi co 1 `h1`
- khong hardcode `<title>` hay `<meta name="description">`
- dung breadcrumb / hero banner de giu heading hierarchy hop ly
- dung semantic blocks nhu `section`, `article`, `aside`, `nav` o cac template chinh

Template da co y thuc SEO ro nhat hien tai:

- `archive.php`
- `search.php`
- `single.php`
- `page.php`
- `author.php`

## 8. Reality Check

### Things that are solid now

- Theme khong con chi la homepage mock nua.
- Da co bo template content kha day du cho blog/theme WordPress that.
- Homepage da co nhieu section duoc dynamic hoa theo dung mot pattern ro rang.
- Single page da co TOC, related posts, author box va sidebar kha day du.
- Search/page/author da duoc bo sung va co layout rieng, khong chi fallback mac dinh.

### Things still simplified or partial

- `index.php` dang trong.
- `404.php` chua co.
- `footer.php` van la hardcode, chua widget/menu driven.
- Header van la simplified clone, chua co parity day du voi mega menu source.
- Section Instagram van la static mock.
- Section Featured Video van la blog-post interpretation, khong con dung semantics video popup goc.
- Nhieu sidebar block bi copy/paste giua `archive.php`, `search.php`, `single.php`, `page.php`, `author.php`; `template-parts/archive-sidebar.php` chua duoc ap dung dong bo.

## 9. Known Risks

### 1. Author style loading co kha nang chua day du

`functions.php` dang enqueue `author.css` khi `is_author()`, nhung khong enqueue `archive.css` cho author page. Trong khi `author.php` reuse rat nhieu class layout cua archive/list/sidebar.

Neu chua co import/noi suy o CSS khac, day la diem can verify.

### 2. Reuse sidebar chua duoc chot

`template-parts/archive-sidebar.php` da ton tai nhung source chinh van con markup duplicate. Moi lan sua sidebar de co nguy co lech template.

### 3. Inline JS trong `single.php`

TOC toggle dang viet inline trong template, nen maintainability thap hon so voi chuyen vao file JS chung.

### 4. Fallback template chua hoan chinh

- `index.php` trong
- `404.php` chua co

## 10. Suggested Next Tasks

1. Chot va verify author-page asset loading
   - quyet dinh co enqueue `archive.css` cho `is_author()` hay khong
2. Reuse `template-parts/archive-sidebar.php` cho `archive/search/page/author/single`
   - giam duplicate markup
3. Tao `404.php`
4. Lam day `index.php` de co fallback template an toan
5. Tiep tuc dynamic hoa cac homepage section con lai neu project di sau hon vao WordPress data
6. Quy chuan hoa Featured Video
   - giu blog-mode va document tiep
   - hoac khoi phuc semantics video neu muc tieu UI doi hoi

## 11. Documentation Rule

- `PROJECT.md` phai mo ta code dang ton tai, khong mo ta du dinh.
- Neu co lech giua doc va code, uu tien code.
- Moi lan them template moi, doi asset loading, doi helper pattern, hoac doi status homepage section thi cap nhat file nay.
