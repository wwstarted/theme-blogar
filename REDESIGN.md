# Blogar Homepage — UI Redesign Tracker

## Mục tiêu

Redesign toàn bộ visual 7 section trang home theo hướng **Penci Design / editorial**.  
**Giữ nguyên:** PHP render logic, WP_Query, JS carousel/tab.  
**Thay đổi:** HTML structure + CSS mới cho từng section.

Quy tắc file: mỗi section [v2] có **file CSS riêng** (không ghi đè frontpage.css cũ),  
enqueue độc lập, dễ rollback.

---

## Thứ tự section mặc định

`s11 → s5 → s13 → s14 → s12 → s4 → s10`

---

## Tiến độ

| ID  | Tên section                     | File CSS            | PHP template | Settings | Status  |
| --- | ------------------------------- | ------------------- | ------------ | -------- | ------- |
| s11 | News Highlight → Penci Featured | `css/s11-penci.css` | ✅           | ✅ [v2]  | ✅ Xong |
| s5  | Trending Topics carousel        | —                   | —            | —        | ⬜ Chưa |
| s13 | Featured Grid 2+3               | —                   | —            | —        | ⬜ Chưa |
| s14 | Latest Posts Grid               | —                   | —            | —        | ⬜ Chưa |
| s12 | Featured Grid This Week         | —                   | —            | —        | ⬜ Chưa |
| s4  | Innovation & Tech tabs          | —                   | —            | —        | ⬜ Chưa |
| s10 | Featured Video                  | —                   | —            | —        | ⬜ Chưa |

**Legend:** ⬜ Chưa · 🔄 Đang làm · ✅ Xong

---

## s11 [v2] — Chi tiết thay đổi

### Layout mới (clone Penci)

```
[ ──────────── 50% ──────────── ] [ ── 25% ── ] [ ── 25% ── ]
[ Big hero image (16:10)         ] [ Mid card  ] [ TRENDING  ]
[ category · title · author·date ] [   top     ] [ NOW label ]
[ ─────────────────────────────  ] [ ───────── ] [ item 1    ]
[ Small ] [ Small ] (2×2 grid)   ] [ Mid card  ] [ item 2    ]
[ card  ] [ card  ]              ] [  bottom   ] [ item 3... ]
                                                 [ ───────── ]
                                                 [ Sm card   ]
                                                 [ Sm card   ]
```

### Mapping data → layout

| Data key             | Source                             | Render vị trí              |
| -------------------- | ---------------------------------- | -------------------------- |
| `grid_posts[0]`      | Admin pick (main_post)             | Big hero left              |
| `grid_posts[1]`      | Admin pick (small_post_1)          | Middle card top            |
| `grid_posts[2]`      | Admin pick (small_post_2)          | Middle card bottom         |
| `ticker_posts`       | Auto 6 latest (not in grid)        | Trending text list right   |
| `recent_posts[0..3]` | Auto 6 latest (not in grid/ticker) | 4 small cards left bottom  |
| `recent_posts[4..5]` | Auto (same query)                  | 2 small cards right bottom |

### Files thay đổi

- `css/s11-penci.css` — **NEW** (enqueue riêng, không đụng frontpage.css)
- `inc/helpers.php` — `blogar_get_news_highlight_block_data()`: thêm `recent_posts`
- `inc/theme-options.php` — s11 labels đổi → `[v2]`, description update
- `front-page.php` — s11 HTML block thay hoàn toàn bằng Penci layout
- `functions.php` — thêm enqueue `blogar-s11-penci` chỉ trên `is_front_page()`

### Settings admin (sau update)

- `[v2] Trending label` — text label trending list (default: "Trending Now")
- `Category filter` — lọc category cho toàn block
- `[v2] Hero post (big featured)` — post chính, hero left
- `[v2] Middle card 1 — top` — card giữa trên
- `[v2] Middle card 2 — bottom` — card giữa dưới
- Small cards + Trending list: **auto-fill** từ latest posts

---

## Design tokens s11 [v2]

| Mục                    | Giá trị                                           |
| ---------------------- | ------------------------------------------------- |
| Hero aspect ratio      | `16 / 10`                                         |
| Hero overlay           | gradient bottom-to-top 84%→0%                     |
| Mid card min-height    | 160px (stretch to fill)                           |
| Small thumb            | 72×54px (4:3)                                     |
| Trending label         | font-weight 800, uppercase, letter-spacing 0.05em |
| Grid gap               | 8px                                               |
| Small card gap         | 1px (tạo line separator via background trick)     |
| Responsive breakpoints | tablet ≤1024px, mobile ≤480px                     |

---

## Ghi chú kỹ thuật

- Class prefix `s11p-*` — không xung đột với code cũ (`blogar-news-highlight-*`)
- CSS cũ cho `.axil-highlight-showcase-area` vẫn còn trong `frontpage.css` nhưng không còn được render (section HTML đã thay)
- JS ticker cũ (`data-news-ticker`) đã bị xóa khỏi DOM → không cần xử lý JS
- `small_post_3` vẫn được `register_setting()` (backward compat) nhưng không dùng trong [v2] layout

---

## Next: s5 — Trending Topics carousel

Khi sẵn sàng redesign s5, tạo `css/s5-penci.css` và thay HTML block s5.
