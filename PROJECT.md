# Blogar Theme Project

## 1. Project Overview

### Summary

`blogar` la custom WordPress theme dang duoc rebuild theo huong clone giao dien tu file tham chieu:

- `C:\My Web Sites\Blogar\new.axilthemes.com\themes\blogar\index.html`

Nguon su that ve UI la `index.html`, khong phai `PROJECT.md` cu. Trang thai code hien tai cho thay:

- Header da duoc rebuild theo phong cach Blogar, co desktop menu, mobile off-canvas, search va cart.
- Footer da duoc rebuild gan day du ve mat thi giac.
- `front-page.php` da clone gan nhu toan bo flow cua homepage goc.
- Mot so logic da duoc custom de theme nhe hon:
  - bo `jQuery`, `Slick`, `Font Awesome`
  - thay bang CSS, vanilla JS, SVG inline
  - data van dang hardcode trong PHP thay vi query dong tu WordPress

### Tech Stack

- WordPress custom theme
- PHP template files
- Vanilla CSS, chia theo module
- Vanilla JavaScript, chia theo page/component
- WooCommerce integration o muc cart count + cart link trong header
- Google Fonts: `Red Hat Display`

### Current Architectural Direction

- Khong phu thuoc vendor frontend runtime cua ban demo goc.
- Clone UI bang HTML, CSS, JS tu viet.
- Tap trung vao homepage truoc; chua thay trien khai day du cho `single`, `archive`, `search results`.

### Target Template Map

Theme duoc dinh huong xoay quanh cac template sau:

- `header.php`
- `footer.php`
- `front-page.php`
- `single.php`
- `archive.php`

Trang thai thuc te hien tai:

- `header.php`: da co
- `footer.php`: da co
- `front-page.php`: da co
- `single.php`: da duoc tao theo layout chi tiet bai viet cua source, render du lieu dong tu WordPress va reuse sidebar chung
- `search.php`: da duoc tao voi UI clone tu `archive.php`, dung main search query cua WordPress
- `archive.php`: da ton tai va dang duoc toi uu UI theo layout list + sidebar cua source

## 2. Folder Structure

### Root Files

- `functions.php`
  - Require runtime helpers tu `inc/helpers.php` va `inc/theme-options.php`.
  - Dang ky menu.
  - Theme support cho `post-thumbnails`.
  - Dang ky custom image sizes cho cac section homepage.
  - Enqueue assets theo module.
  - Tao fallback menu.
  - Lay cart count tu WooCommerce.
- `header.php`
  - Render header desktop/mobile.
  - Search form, cart icon, mobile menu shell.
- `footer.php`
  - Render footer menu columns, social, bottom links, copyright.
- `front-page.php`
  - Template homepage chinh.
  - Chua toan bo section tu hero toi Instagram.
- `style.css`
  - File theme header toi thieu de WordPress nhan dien theme.
- `index.php`
  - Hien trong, chua dong vai tro fallback template thuc te.
- `PROJECT.md`
  - Tai lieu trang thai project. Bat buoc cap nhat sau moi thay doi dang ke.

### CSS

- `css/style.css`
  - Global tokens toi thieu: mau, font, radius, shadow, reset co ban.
  - Hien con mong; nhieu token cua demo goc chua duoc port day du.
- `css/header.css`
  - Layout header, dropdown desktop, off-canvas mobile, sticky behavior, search/cart styles.
- `css/footer.css`
  - Footer grid, social icons, copyright.
- `css/frontpage.css`
  - Toan bo homepage styling.
  - Chua phan lon logic pixel layout cho 11 section.
  - Chua responsive rules cho hero, tab carousel, category carousel, grids, sidebar, Instagram.

### JavaScript

- `js/header.js`
  - Sticky header.
  - Open/close mobile menu.
  - Toggle mobile search.
  - Expand/collapse submenu tren mobile.
- `js/footer.js`
  - Hien trong.
- `js/frontpage.js`
  - Hero slider.
  - Generic `createCarousel()`.
  - Tabs logic.
  - Trending Topics carousel.
  - Copy link behavior.

### Includes

- `inc/helpers.php`
  - Helper layer dung chung cho theme.
  - Gom reading time, category renderer, social share URLs, thumbnail fallback/alt, va query helpers/data builders cho homepage.
  - La noi doc `wp_options`, build `WP_Query` hoac data array da chuan hoa, va cung cap fallback khi admin chua cau hinh.
- `inc/theme-options.php`
  - Tao trang `Appearance > Blogar Settings`.
  - Dang ky Settings API cho homepage sections.
  - La noi khai bao option groups, field callbacks, admin tabs va UI config cho cac section duoc refactor sang dynamic.
  - Hien dang noi vao flow dynamic cho Section 1, Section 4 va Section 5.
  - Dong thoi quan ly custom admin field cho category thumbnail (`blogar_category_image_id`) de Section 5 uu tien dung anh taxonomy rieng.
- `inc/theme-setup.php`
  - Hien trong / chua tham gia flow runtime.
- `inc/header-setup.php`
  - Hien chua duoc dung.
- `inc/footer-setup.php`
  - Hien chua duoc dung.

### Assets

- `images/logo/*`
  - Logo dark/light.
- `images/icons/*`
  - Hinh trang tri cho homepage.
- `images/frontpage/*`
  - Local mirror cua assets homepage goc.

## 3. File-to-Function Mapping

### Header System

- `header.php`
  - Markup header chinh.
  - `wp_nav_menu()` cho desktop va mobile.
  - Search desktop/mobile.
  - WooCommerce cart count badge.
- `css/header.css`
  - Pixel/layout rules cho header.
  - Dropdown, sticky, mobile off-canvas.
- `js/header.js`
  - Sticky class toggle khi scroll.
  - Mobile menu overlay state.
  - Mobile search expand/collapse.

### Footer System

- `footer.php`
  - Footer hien dung mang hardcode thay cho dynamic widget/menu structure.
- `css/footer.css`
  - Clone layout 6 cot desktop, responsive xuong 2 cot roi 1 cot.
- `js/footer.js`
  - Chua co behavior.

### Homepage System

- `front-page.php`
  - Render 11 section homepage.
  - Section 1 da chuyen sang dynamic render tu admin settings + helper query.
  - Cac section con lai van phan lon hardcode.
  - Dung inline SVG de thay the icon library.
- `css/frontpage.css`
  - Noi quyet dinh pixel fidelity chinh cua homepage.
- `js/frontpage.js`
  - Noi quyet dinh carousel, tabs, interactions cua homepage.

## 4. UI/UX Clone Rules

Day la rule bat buoc cho moi lan chinh sua tiep theo.

### Source of Truth

- Luon doi chieu voi `index.html` truoc khi code.
- Khong suy doan theo tri nho.
- Khong dung `PROJECT.md` cu lam nguon su that.

### Pixel-Perfect Requirements

- Muc tieu la giong ban goc theo block structure, spacing rhythm, card proportions, typography hierarchy va responsive behavior.
- Khong chap nhan kieu "na na", "xap xi", "same vibe".
- Moi section da hoan thanh phai giu nguyen:
  - khoang cach top/bottom
  - radius
  - border treatment
  - card stacking order
  - vi tri arrow/button
  - ty le anh
  - cach text wrap

### Spacing Rules

- Khong tu y doi `padding`, `gap`, `margin`, `min-height` neu chua doi chieu lai ban goc.
- Khi sua mot section, phai kiem tra luon:
  - desktop
  - tablet
  - mobile
- Dac biet chu y cac vung de lech:
  - hero content card
  - arrow offset ngoai container
  - tab spacing
  - sidebar widget spacing
  - footer grid spacing

### Typography Rules

- Dung `Red Hat Display` nhu theme hien tai.
- Khong doi font stack neu khong co ly do ro rang.
- Khong giam co chu de "fit tam".
- Khong doi weight/line-height lam mat hierarchy goc.

### Interaction Rules

- Neu source dung carousel/tab/hover state, ban clone phai co behavior tuong duong ve UX.
- Co the thay library, nhung khong duoc thay trai nghiem thi giac chinh.
- Cho phep re-implement bang vanilla JS neu output nhin va hoat dong tuong duong.

## 5. SEO and HTML Rules

Day la nhom rule bat buoc, khong duoc xem nhe.

### One H1 Per Template

- Moi template chi duoc co 1 the `<h1>`.
- Rule nay ap dung cho:
  - `front-page.php`
  - `single.php`
  - `archive.php`
  - bat ky template moi nao duoc them sau nay

### Metadata Rules

- Khong hardcode:
  - `<title>`
  - `<meta name="description">`
- De plugin SEO nhu Yoast SEO hoac Rank Math xu ly.
- `header.php` chi nen giu:
  - charset
  - viewport
  - `wp_head()`

### Semantic HTML

- Dung dung the HTML semantic:
  - `<section>` cho block noi dung lon
  - `<article>` cho don vi bai viet
  - `<nav>` cho menu/dieu huong
  - `<aside>` cho sidebar/noi dung phu
- Khong dung `div` thay cho semantic block neu block do da co nghia ro rang.

### Heading Hierarchy

- Phai giu thu tu heading hop ly:
  - `h1` -> `h2` -> `h3`
- Khong skip level neu khong co ly do rat ro rang.
- Moi section trong homepage nen bat dau tu `h2` khi `h1` da duoc dung cho hero/page heading.

### SEO Safety Rules

- Khong vi ly do pixel-perfect ma pha heading hierarchy.
- Khong doi heading thanh `div` chi de de style.
- Khong them text an/covert heading chi de "seo".
- Neu source UI co text giong heading nhung khong phu hop hierarchy, phai can bang giua semantic dung va clone UI dung, uu tien solution giu duoc ca hai.

## 6. Custom Logic

Nhung custom duoi day la co y, khong phai bug, tru khi co chi dinh nguoc lai.

### Dependency Simplification

- Demo goc dung `jQuery`, `Slick`, `Font Awesome`, plugin Instagram feed, nhieu asset/plugin WordPress.
- Theme hien tai da custom sang:
  - vanilla JS
  - custom carousel factory
  - inline SVG icons
  - local image assets

### Carousel System Rewrite

- `createCarousel(wrapper, options)` trong `js/frontpage.js` la abstraction dung chung.
- No thay cho Slick o cac khu vuc:
  - Innovation & Tech tabs carousel
  - Trending Topics carousel

### Featured Video Section Custom

Section nay la custom quan trong nhat.

Trong source goc:

- section la "Featured Video"
- behavior thien ve video content / popup semantics

Trong code hien tai:

- van giu visual direction cua section video
- nhung noi dung da chuyen sang blog post mode
- click di toi bai viet thay vi mo popup video

Tuc la:

- `video popup/lightbox`: khong con
- `blog article navigation`: da thay vao
- `video-play-indicator`: da duoc remove khoi markup va CSS de dark UI sach hon

### Instagram Section Custom

Source goc:

- dung plugin/feed structure thuc te
- co heading/feed wrapper dac trung cua plugin

Code hien tai:

- dung 6 static image cards
- chi clone visual grid co ban
- khong co live feed/plugin data

### Header Simplification

Source goc:

- co menu structure phuc tap hon
- co mega menu
- nhieu class/plugin behavior tu theme goc

Code hien tai:

- menu structure don gian hon
- fallback menu chi la ban rut gon
- chua clone mega menu that

## 7. Implemented Sections

Danh gia duoi day dua tren doi chieu code hien tai voi `index.html`.

### Global Layout Blocks

| Block | Status | Fidelity | Notes |
| --- | --- | --- | --- |
| Header | Partial | Gan pixel-perfect hon | Da audit lai flow desktop/tablet/mobile: sua align actions, sticky offset, tablet search inline va mobile nav usable hon; chua co mega menu parity day du nhu source |
| Footer | Done | Gan pixel-perfect | Layout 6 cot, social, bottom links da co; data dang hardcode, chua dynamic nhu WordPress widgets/menu |

### Homepage Sections

| # | Section | Status | Fidelity | Notes |
| --- | --- | --- | --- | --- |
| 1 | Hero Slider | Done | Gan pixel-perfect | Da chuyen tu hardcode sang dynamic render: admin chon bai trong `Appearance > Blogar Settings`, helper query lay du lieu/fallback 3 bai moi nhat, template render theo post data that; van dung vanilla slider thay Slick |
| 2 | More Featured Posts | Done | Gan pixel-perfect | Da audit lai theo source: fix card alignment, thumbnail tron, spacing title/meta va responsive tablet/mobile |
| 3 | Banner Ad | Done | Gan pixel-perfect | Da audit lai layout/image handling: banner centered trong container, khong co spacing noi bo thua, responsive scale dung ti le |
| 4 | Innovation & Tech | Done | Gan pixel-perfect | Da audit lai arrow/tab carousel: arrow duoc keo vao trong container, giam size button/icon, va sua desktop/tablet positioning theo layout |
| 5 | Trending Topics | Done | Gan pixel-perfect | Da audit lai categories carousel: arrow duoc keo vao trong container, giam size button/icon, va sua desktop/tablet positioning de khong vuot padding; da refactor sang dynamic taxonomy data + category thumbnail rieng |
| 6 | Most Popular (trending list tabs) | Done | Gan pixel-perfect | Da audit lai list + preview thumbnail: fix grid ti le, meta row author/date/social, spacing va responsive stack tren tablet/mobile; da refactor sang dynamic tab queries tu admin settings |
| 7 | Social / Share strip block | Done | Gan pixel-perfect | Nam trong `axil-post-grid-area`, da clone visual chinh |
| 8 | Most Popular Grid | Done | Gan pixel-perfect | Da audit lai grid 2 cot + overlay card: fix meta row cua big card, spacing card, va responsive stack cho tablet/mobile; da refactor sang dynamic tab queries tu admin settings |
| 9 | Post List + Sidebar | Done | Gan pixel-perfect | Da refactor main list + recent widget sang dynamic data tu admin settings; khoa thumbnail `blogar-list` + `blogar-thumb` bang ratio co dinh, `object-fit: cover`, va clamp title de tranh vo layout voi featured image thuc te |
| 10 | Featured Video | Done | Gan pixel-perfect | Da refactor sang dynamic data tu admin settings: chon 1 bai lon + 4 bai nho; khoa thumbnail `600x500` va `285x190` bang crop/ratio co dinh de tranh vo layout |
| 11 | Instagram | Done | Gan pixel-perfect | Da clone lai theo huong feed grid 6 cot, item 1:1, co profile header, overlay hover va responsive 4 cot tablet / 2 cot mobile; du lieu van la static local assets |

### Section-by-Section Detail

#### 1. Hero Slider

- Files: `front-page.php`, `css/frontpage.css`, `js/frontpage.js`
- Clone:
  - hero image slider
  - overlay white content card
  - author/meta/share/read-post pattern
- Data flow moi:
  - `inc/theme-options.php`: tao tab Hero trong `Appearance > Blogar Settings`
  - admin chon toi da 3 post qua Settings API va luu vao `wp_options` voi keys `blogar_hero_slide_1..3`
  - `inc/helpers.php`: `blogar_get_hero_posts()` doc options, giu dung thu tu `post__in`, fallback 3 bai moi nhat neu chua cau hinh
  - `front-page.php`: loop `WP_Query` va render markup tu du lieu post that thay cho content hardcode
- Helper layer dang duoc dung trong render:
  - `blogar_reading_time()` de tinh `x min read`
  - `blogar_post_categories_html()` de render category links theo UI hover-flip
  - `blogar_thumbnail_url()` + `blogar_thumbnail_alt()` de lay featured image va fallback/alt an toan
  - `blogar_social_share_urls()` de tao share links Facebook, Twitter, LinkedIn
- Render rules moi trong template:
  - slide dau tien dung `h1` + `loading="eager"` + `fetchpriority="high"` cho SEO/perf
  - cac slide sau dung `h2` + `loading="lazy"`
  - author, avatar, date, reading time, share buttons va CTA deu lay tu du lieu WordPress
- Custom:
  - vanilla JS autoplay 5s
  - manually built prev/next arrows
- Audit/fix moi nhat:
  - them lai class section theo convention `axil-section-gap`
  - thay token thieu trong slider bang gia tri design goc de typography khong bi sai mau/co chu
  - fix lai title, category, meta, social icon color trong card overlay
  - fix lai overlay card spacing va width o desktop/tablet
  - canh lai hang meta desktop/tablet de author, social va `Read Post` cung truc hang va khong de len nhau
  - doi meta row sang flex flow on dinh hon; day `Read Post` ra phai bang negative margin de giong source nhung khong che social icon
  - sua lai arrow spacing o tablet theo offset source
  - remove top gap mobile giua slider va header
  - giu mobile stack card + arrow offset sat source hon
- Risks:
  - avatar van goi Gravatar external
  - Hero Slider la pattern refactor chuan cho kieu section chon post cu the theo thu tu

#### 2. More Featured Posts

- Clone kha sat ve:
  - card shell
  - anh tron
  - spacing text/meta
- Audit/fix moi nhat:
  - fix card sang `align-items: center` dung source
  - tang thumbnail tron desktop len 250px, giam dung theo breakpoint goc
  - fix lai spacing category va meta row theo source
  - fix responsive mobile theo kieu card stack, text truoc anh sau, khong vo layout
- Chua thay query dong tu posts thuc.

#### 3. Banner Ad

- Section don gian.
- Audit/fix moi nhat:
  - khoa banner ve centered image block dung source
  - remove spacing noi bo thua trong section
  - dam bao image scale 100% va giu ti le tren desktop/tablet/mobile
- It rui ro UI.

#### 4. Innovation & Tech

- Co tabs + per-tab carousel.
- Clone dung intent cua source.
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 4 trong `Appearance > Blogar Settings`
  - admin cau hinh title, so bai moi tab, va toi da 3 tab gom `label + category`
  - `inc/helpers.php`: `blogar_get_innovation_data()` doc options, build data array dang `title + tabs`, moi tab chua `label + WP_Query`
  - fallback: neu chua cau hinh tab nao thi tu lay 3 category co bai viet nhieu nhat
  - `front-page.php`: chi consume data array tu helper de render tab nav + carousel cards
- Audit/fix moi nhat:
  - keo arrow vao trong layout cua tab carousel, khong de tran ra ngoai container
  - giam nhe button/icon size de dung ti le hon voi source
  - sua positioning desktop/tablet va giu mobile arrows ben duoi khong vo layout
- Custom implementation tot, nhung can giu chat:
  - gap 30px
  - arrow offset
  - card min-height
- Refactor role:
  - la pattern refactor chuan cho kieu section co section settings + nested item settings + helper tra ve data array phuc hop cho template

#### 5. Trending Topics

- Da duoc rewrite dung huong:
  - card vuong
  - anh full cover
  - text overlay o day
  - hover zoom
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 5 trong `Appearance > Blogar Settings`
  - admin cau hinh title, so luong category va danh sach category duoc render
  - admin co them field upload thumbnail truc tiep trong man hinh add/edit category cua taxonomy `category`
  - `inc/helpers.php`: `blogar_get_trending_topics_data()` doc options, lay dung categories da chon va build data array cho template
  - thumbnail cua moi category duoc lay qua `blogar_get_category_thumbnail_data()`
  - uu tien term meta `blogar_category_image_id` neu co; fallback ve featured image moi nhat cua post trong category; neu van khong co thi dung placeholder an toan
  - `front-page.php`: chi loop data categories va render carousel item gom thumbnail + category title
- Da fix rieng arrow cua categories section de nam trong container thay vi tran ra ngoai padding.
- Da giam size button/icon va reposition lai cho desktop + tablet; mobile van giu flow arrow phia duoi de tranh vo layout.
- Refactor role:
  - la pattern refactor cho kieu section render tu taxonomy data thay vi post loop, nhung van giu flow `theme-options -> helpers -> front-page`

#### 6. Most Popular Trend List

- Co tab switching.
- Hover/focus doi active item.
- Preview thumbnail behavior da duoc custom bang class toggle thay cho script goc.
- Da audit lai layout side-by-side cua list va preview thumbnail theo source.
- Meta row trong tung item duoc giu tren 1 hang o desktop/tablet, khong overlap; mobile moi cho wrap co kiem soat.
- Da chuan hoa spacing, mau meta, va width preview thumbnail de bam source hon.
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 6 trong `Appearance > Blogar Settings`
  - admin cau hinh title, so post moi tab, sort mode (`latest` / `popular`) va toi da 4 tab gom `label + category`
  - `inc/helpers.php`: `blogar_get_most_popular_list_data()` doc options, build data array dang `title + tabs`, moi tab chua `label + WP_Query`
  - helper query dung chung `blogar_build_posts_query_args()` de giam lap code va giu sort/filter nhat quan
  - `popular` hien tai dua tren `comment_count` cua WordPress vi project chua co view-count meta rieng
  - `front-page.php`: chi consume data tu helper, loop query va render numbered list + preview thumbnail
- Helper layer dang duoc dung trong render:
  - `blogar_reading_time()`
  - `blogar_post_categories_html()`
  - `blogar_thumbnail_url()` + `blogar_thumbnail_alt()`
  - `blogar_social_share_urls()`
- Fallback:
  - neu chua cau hinh tab nao thi helper se fallback sang 4 category phu hop
  - neu mot tab khong co bai viet thi template van render empty-state an toan, khong vo layout

#### 7. Social / White Card Area

- Da clone khoi social card trong flow homepage.
- Can giu spacing va border-radius hien tai.

#### 8. Most Popular Grid

- Da co big card + small cards structure.
- Responsive rules da co nhung la vung de phat sinh lech neu thay min-height/padding.
- Da audit lai grid desktop 2 cot va card overlay theo source.
- Meta row cua big card duoc giu 1 hang o desktop/tablet, khong overlap; mobile moi cho wrap co kiem soat.
- Da chuan hoa spacing giua grid cards va responsive stack cho tablet/mobile.
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 8 trong `Appearance > Blogar Settings`
  - admin cau hinh title, so tab duoc render, va tung tab gom `label + category + post slot 1/2/3`
  - `inc/helpers.php`: `blogar_get_most_popular_grid_data()` doc options va build data array dang `title + tabs`, moi tab chua `label + posts`
  - helper `blogar_get_configured_posts()` uu tien post admin da chon theo dung thu tu slot, sau do moi fallback ve post moi nhat trong category neu slot con thieu
  - moi tab render dung 3 post: post 1 = big card, post 2 va 3 = small cards
  - `front-page.php`: chi consume data tu helper va giu nguyen structure grid hien tai
- Helper layer dang duoc dung trong render:
  - `blogar_post_categories_html()`
  - `blogar_thumbnail_url()` + `blogar_thumbnail_alt()`
  - `blogar_reading_time()`
  - `blogar_social_share_urls()`
- Fallback:
  - neu chua cau hinh tab/category nao trong admin settings, helper se fallback sang cac category co bai viet
  - neu tab khong co bai viet, template van render safe fallback va khong vo layout
- UI note:
  - tren desktop, thumbnail cua grid da duoc khoa lai chieu cao co dinh de giu dung bo cuc bat doi xung goc
  - big thumbnail duoc canh cao bang tong chieu cao 2 thumbnail nho + khoang gap giua chung

#### 9. Post List + Sidebar

- Da clone:
  - banner image
  - post list view
  - sidebar search
  - recent posts
  - social icons
  - gallery
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 9 trong `Appearance > Blogar Settings`
  - admin cau hinh so luong post main list, category filter, sort mode (`latest` / `popular`), recent widget title, recent widget count va category filter cho widget
  - `inc/helpers.php`: `blogar_get_post_list_sidebar_data()` doc options va tra ve `main_query + recent_query + recent_title`
  - `front-page.php`: chi consume data tu helper de render main list va recent widget, giu nguyen structure HTML hien tai
- Helper layer dang duoc dung trong render:
  - `blogar_thumbnail_url()` + `blogar_thumbnail_alt()` de lay featured image va fallback placeholder an toan
  - `blogar_post_categories_html()` de render category theo UI hover-flip
  - `blogar_reading_time()` cho meta `x min read`
  - `blogar_social_share_urls()` cho share buttons cua main list
- UI hardening:
  - main list thumbnail duoc khoa ratio `300 / 169` va render bang `object-fit: cover`
  - recent widget thumbnail duoc khoa ratio vuong `1 / 1`
  - title duoc clamp de tranh item bi cao bat thuong khi data thuc te qua dai
- Da fix responsive mobile cho `post-list-layout` de stack 1 cot dung source, tranh sidebar bi chen sang ben phai.
- Tren mobile, `post-list-view` da chuyen sang layout doc: image full-width o tren, content full-width o duoi.
- Da toi uu them spacing va thumbnail cua sidebar widgets de tranh text bi bop hep tren man hinh nho.

#### 10. Featured Video

- Trang thai hien tai la "visual clone + blog-post logic custom".
- Khong nen tiep tuc goi day la video popup neu chua khoi phuc popup/video player.
- Da remove hoan toan `video-play-indicator` khoi HTML va CSS.
- Da fix contrast dark UI:
  - title hover giu mau trang
  - post author name dung mau sang de doc duoc tren nen den
- Da khoi phuc hover animation cho author name theo kieu `hover-flip-item`:
  - section nen sang dung mau before toi
  - section video dung mau before trang
- Da them `justify-content-end` cho social row cua big card va khoa meta row dark UI de desktop khong wrap sai; mobile moi cho wrap co kiem soat.
- Da chuan hoa lai spacing cua section nay ve blog-mode dark UI (`30px 0`) theo source.
- Data flow moi:
  - `inc/theme-options.php`: tao tab settings rieng cho Section 10 trong `Appearance > Blogar Settings`
  - admin cau hinh section title, 1 big post va 4 small posts
  - `inc/helpers.php`: `blogar_get_featured_video_data()` doc options, build du 5 slot theo thu tu va fallback bang cac bai moi nhat neu admin chua chon du
  - `front-page.php`: chi consume data helper, render big card ben trai va grid 2x2 ben phai tu post data that
- Helper layer dang duoc dung trong render:
  - `blogar_thumbnail_url()` + `blogar_thumbnail_alt()`
  - `blogar_post_categories_html()`
  - `blogar_reading_time()`
  - `blogar_social_share_urls()`
- UI hardening:
  - big thumbnail duoc khoa theo ratio `600 / 500`
  - 4 small thumbnails duoc khoa theo ratio `285 / 190`
  - title small cards duoc clamp 2 dong de tranh vo grid khi title qua dai

#### 11. Instagram

- Da hoan thien lai visual structure theo source:
  - co heading
  - co profile row `axilthemes`
  - grid 6 item deu nhau
  - thumbnail ratio 1:1
  - hover overlay + Instagram icon center
- Responsive hien tai:
  - desktop: 6 cot
  - tablet: 4 cot
  - mobile: 1 cot
- Du lieu van la static/local images, khong phai live plugin feed.

## 8. Global Components

### `createCarousel()`

Files:

- `js/frontpage.js`

Vai tro:

- Factory tai su dung cho nhieu carousel.
- Nhan:
  - `slideSelector`
  - `gap`
  - `slidesToShowFn`
- Tra ve:
  - `reset()`
  - `resize()`

Dang duoc dung cho:

- Innovation & Tech tab carousel
- Trending Topics carousel

Rule:

- Moi carousel moi trong homepage nen uu tien tai su dung factory nay thay vi viet slider moi.
- Khong duplicate logic width/track/arrow neu chua thuc su can.

### Header Behavior

Files:

- `header.php`
- `css/header.css`
- `js/header.js`

Behavior hien co:

- sticky khi scroll > 10px
- dropdown desktop bang CSS hover
- mobile off-canvas menu
- mobile submenu toggle
- tablet search inline, mobile search toggle duoi 768px
- WooCommerce cart badge

### Footer Behavior

Files:

- `footer.php`
- `css/footer.css`

Behavior:

- Chu yeu la visual layout.
- `js/footer.js` hien chua dung.

### Copy Link Buttons

Files:

- `js/frontpage.js`

Behavior:

- click `.axilcopyLink` se copy `data-link`
- co fallback `document.execCommand("copy")`

## 9. Coding Conventions

### PHP

- Giu template theo module ro rang: header, footer, front-page.
- Escape output bang `esc_url`, `esc_attr`, `esc_html` khi phu hop.
- Neu chi la clone tam voi data hardcode, phai ghi ro trong `PROJECT.md`.
- Khong chuyen ngau nhien tu hardcode sang WP query neu chua co task ro rang, vi co the lam lech UI.
- Khong hardcode SEO metadata trong template files.
- Moi template phai tu kiem tra lai so luong `h1` truoc khi chot task.

### Dynamic Refactor Pattern

- Pattern chuan cho homepage sections duoc refactor la:
  - `theme-options.php` quan ly admin settings
  - `helpers.php` doc options va build query/data
  - `front-page.php` chi giu render layer
- Khong nhung query phuc tap hoac logic fallback truc tiep vao template neu no co the dat trong helper.
- Settings layer chi chiu trach nhiem:
  - register option
  - sanitize input
  - render admin field
  - to chuc admin tabs/sections
- Helper layer chi chiu trach nhiem:
  - doc `get_option()`
  - build `WP_Query` hoac data array da chuan hoa
  - giu fallback an toan neu admin chua cau hinh
  - cung cap data contract ro rang cho template
- Template layer chi chiu trach nhiem:
  - goi helper
  - loop data/query
  - render markup theo source UI
  - lay cac field hien thi nhu title, permalink, thumbnail, category, meta, share
- Duoc phep co 2 kieu helper return:
  - tra truc tiep `WP_Query` neu section don gian kieu Hero
  - tra data array chua nested `WP_Query` neu section phuc hop kieu Section 4
- Moi section refactor moi phai uu tien tai su dung helper chung dang co:
  - `blogar_reading_time()`
  - `blogar_post_categories_html()`
  - `blogar_thumbnail_url()`
  - `blogar_thumbnail_alt()`
  - `blogar_social_share_urls()`
- Section 1 va Section 4 la hai pattern mau chinh thuc de follow cho cac section homepage refactor tiep theo.

### CSS

- Uu tien chia theo file:
  - global
  - header
  - footer
  - frontpage
- Trong `frontpage.css`, giu comment section ro rang theo tung khoi lon.
- Khong duoc sua token global de va cuc bo mot section.
- Khi fix mot section, uu tien scope selector theo section do.

### JS

- Dung vanilla JS.
- Viet theo pattern init function:
  - `initSlider()`
  - `initTabs()`
  - `initCategoryCarousel()`
  - `initCopyLinks()`
- Reuse function chung thay vi copy logic.

### Naming

- Ton trong naming dang bam theo theme goc:
  - `axil-*`
  - `content-block`
  - `post-*`
- Co the them class moi neu can, nhung khong rename class clone dang hoat dong on dinh.

## 10. Pixel-Perfect Assessment

### Areas Doing Well

- Homepage section flow da kha day du.
- Hero, featured posts, Innovation & Tech, Trending Topics, Most Popular Grid dang bam source kha tot.
- Responsive intent da duoc cham tuong doi ky.

### Areas Not Yet Fully Pixel-Perfect

- Header chua dat full parity voi source:
  - thieu mega menu
  - menu content don gian hon
  - behavior/theme classes chua day du nhu demo
- Featured Video khong con dung logic source vi da doi sang blog-mode.
- Instagram chua giong han source vi van la static grid, khong phai live/plugin feed structure.
- Global design token layer con mong; nhieu typography token cua source chua duoc port het, nen viec giu pixel-perfect dai han se kho hon.
- Hero slider da duoc patch rieng de tranh le thuoc vao token global con thieu; cac section khac van nen duoc audit rieng neu dang dung cac token nay.

### Important Interpretation

- Khong the ket luan "100% pixel-perfect" cho toan project o trang thai hien tai.
- Danh gia dung nhat la:
  - homepage: da clone du khung va da rat gan source
  - nhung van con mot so block custom / simplified / partial

## 11. Known Issues

- `PROJECT.md` cu khong phan anh dung trang thai hien tai cua project.
- `index.php` dang trong.
- `js/footer.js` trong.
- Header fallback menu la ban rut gon, khong phan anh menu source day du.
- Footer data hardcode, chua dynamic theo menu/widget.
- Homepage content da bat dau chuyen sang dynamic:
  - Section 1 (Hero Slider) da query tu posts that qua Settings API + helper layer
  - Section 4 (Innovation & Tech) da query tu categories/settings qua helper data array + tab queries
  - Section 5 (Trending Topics) da query tu categories da chon trong admin settings va render carousel tu taxonomy data
  - Section 6 (Most Popular numbered list) da query tu posts theo settings + category tabs + sort mode
  - Section 8 (Most Popular grid) da query tu posts theo settings + category tabs va split big/small cards trong render
  - cac section con lai van phan lon hardcode trong `front-page.php`
- Featured Video chi gia lap visual play button, khong co video popup/lightbox.
- Instagram la static images, chua phai live feed/plugin render.
- Global token layer van chua day du nhu source goc; slider da duoc harden cuc bo, nhung cac block khac co the con gap lech typography neu tiep tuc dung token chua port.
- Mot so URL trong homepage dang la `#` hoac absolute/internal-style link, can review neu chuyen sang moi truong that.
- Avatar tac gia dang dung Gravatar external URL.
- `archive.php` da ton tai va dang render du lieu dong; `search.php` da ton tai va clone UI archive; `single.php` da duoc tao va clone UI single-post cua source.

## 12. Next Tasks

Uu tien thuc te nen la:

1. Chot header parity voi source:
   - review mega menu
   - review spacing/menu behavior
2. Quyet dinh ro Section 10:
   - giu blog-mode va document hoa ro hon
   - hoac tra ve video popup mode
3. Nang cap Section 11 neu can sat source:
   - clone plugin/feed structure gan hon
   - hoac document ro la "static Instagram mock"
4. Chuyen du lieu homepage tu hardcode sang data/query co kiem soat neu project buoc sang phase WordPress that
   - nen tiep tuc theo pattern da ap dung cho Hero Slider:
   - `theme-options.php` luu config
   - `helpers.php` dam nhiem query + transform data
   - `front-page.php` chi giu render layer
5. Tao `404.php` neu muc tieu la hoan thien theme; `archive.php`, `search.php`, `single.php` da co va dang duoc polish them
6. Don lai cau truc `inc/` neu muon scale project
7. Khi tao template moi, ap dung ngay:
   - 1 `h1`
   - semantic HTML
   - khong hardcode SEO metadata

## 13. AI Workflow Rules

Day la phan bat buoc cho moi AI/dev tham gia tiep theo.

### Before Coding

- Doc `index.html` truoc.
- Doc section tuong ung trong `front-page.php`, CSS, JS.
- Xac dinh:
  - dang clone section nao
  - section do status gi trong `PROJECT.md`
  - co custom logic nao can giu nguyen khong
  - co anh huong toi SEO/heading hierarchy khong

### While Coding

- Khong pha section da `Done` neu task chi lien quan section khac.
- Khong "refactor dep hon" neu co rui ro doi layout.
- Khong doi spacing/typography global de cuu mot loi cuc bo.
- Neu thay logic, phai ghi ro do la:
  - clone dung source
  - hay custom by intent
- Neu dang refactor hardcode sang dynamic, phai doi chieu voi Section 1 va Section 4 truoc:
  - settings nam trong `theme-options.php`
  - query/data builder nam trong `helpers.php`
  - template khong giu logic cau hinh admin
  - phai co fallback neu admin chua cau hinh

### After Coding

- Bat buoc cap nhat `PROJECT.md` neu:
  - hoan thanh section moi
  - doi status fidelity
  - them custom logic
  - fix known issue
  - thay doi global component
  - thay doi heading structure
  - thay doi semantic HTML
  - tao template moi

### Documentation Rule

- `PROJECT.md` luon phai phan anh code hien tai, khong phan anh ke hoach hay mong muon.
- Neu co chenh giua tai lieu va code, code thang.

### Review Checklist Before Closing Any Task

- Da doi chieu voi `index.html`
- Da giu pixel-perfect trong pham vi task
- Khong phat sinh them `h1`
- Khong hardcode `<title>` hoac meta description
- Heading hierarchy van hop ly
- Semantic HTML van dung
- `PROJECT.md` da cap nhat neu co thay doi logic/trang thai

## 14. Current Reality Snapshot

Neu mot AI khac vao project ngay bay gio, nen hieu nhu sau:

- Day la theme WordPress clone homepage Blogar bang custom PHP/CSS/vanilla JS.
- Homepage da duoc dung gan day du 11 section.
- Hero Slider va Innovation & Tech da khong con la block hardcode; ca hai dang la pattern mau cho huong data-driven WordPress co fallback.
- Section 5 va Section 6 da tiep tuc follow dung pattern do cho taxonomy carousel va tabbed post list.
- Section 8 da tiep tuc follow cung pattern do cho tabbed post grid (1 big post + 2 small posts moi tab).
- Cac section manh nhat hien tai la hero, featured posts, tab/carousel areas, grid/list blocks.
- Cac section con custom/partial ro nhat la:
  - header
  - featured video logic
  - instagram
- Project dang chuyen dan tu clone giao dien tinh sang data-driven WordPress, voi Section 1 va Section 4 la hai pattern refactor da duoc chot, va Section 5 da duoc implement theo dung flow do cho taxonomy data.
- Featured Video dark UI da duoc toi uu contrast sau khi remove indicator va fix mau title/author.
