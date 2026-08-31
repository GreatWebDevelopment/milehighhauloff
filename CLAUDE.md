# Mile High Haul Off — Project Instructions

**GWD Project ID:** 97 | **Client:** Jeremy Bedard (Mile High Haul Off, milehighhauloff@gmail.com, 720-999-0941) — same owner as Colorado Pest Pros (project 94/copestpros)
**Live site:** https://milehighhauloff.com/ (WordPress — being replaced by this repo)

## Layout

- `backend/` — the new Laravel 12 + Vue 3 + Inertia + Tailwind 4 site (replaces WordPress)
- `milehighhauloffold/` — full wget mirror backup of the old WP site (513 files, do not edit)
- `wp-export/` — WordPress REST API export: posts/pages/services/media JSON + all original uploads
- `url-catalog.json` / `OLD-SITE-URL-INVENTORY.md` — per-URL SEO inventory of the old site
- `SEO_TRANSITION_STRATEGY.md` — URL preservation + redirect plan; **read before changing any route**

## Hard rules

1. **Never change a public URL path.** All 41 indexed URLs (pages, `/services/{slug}/`, category-prefixed blog posts `/cleanout|removal|outside-cleanup/{slug}/`) must keep returning 200. Verify against `url-catalog.json`.
2. `/invoice/*` must stay **410** — 205 client invoices were leaked by the old WP GetPaid plugin.
3. Old `/wp-content/uploads/` image paths are served from `backend/public/wp-content/uploads/` — don't move them.
4. Blog post content is migrated WP HTML rendered via `.wp-content` prose styles — edit in DB/seeder data, not by hand-mangling HTML.

## Backend notes

- Content lives in `services` / `blog_posts` tables, seeded from `backend/database/seeders/data/*.json` (`php artisan db:seed --class=ContentSeeder` is idempotent).
- SEO meta is passed as an `seo` prop from routes and rendered **server-side** in `resources/views/app.blade.php` (title, meta, OG, JSON-LD). In JSON-LD blocks, `@context` must be written `@@context` (Blade directive collision).
- Business facts (phone, address, hours, service areas, gtag `GT-MQB8X74N`) live in `config/site.php`.
- Forms post to `/submit/quote` and `/submit/contact` → `form_submissions` table (+ optional email via `mail.notify_to`).
- Sitemap: `/sitemap.xml` (SitemapController), robots at `public/robots.txt`.

## Open scope decision (before launch)

The client actively invoices through the old WP site (GetPaid plugin, last invoice Aug 2026). Billing replacement (Stripe invoicing vs. Laravel portal vs. third-party) is undecided — see SEO_TRANSITION_STRATEGY.md §6. The legacy billing URLs currently 302 to `/contact`.
