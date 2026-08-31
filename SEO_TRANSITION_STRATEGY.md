# Mile High Haul Off — Website Rebuild & SEO Transition Strategy

**Client:** Mile High Haul Off (milehighhauloff@gmail.com, 720-999-0941)
**Current Site:** https://milehighhauloff.com/
**GWD Project ID:** 97
**Date:** August 31, 2026
**Prepared by:** Great Web Development

---

## Executive Summary

Mile High Haul Off runs on WordPress (Uncode theme + "rounded-digital" child theme, Yoast SEO, Gravity Forms, Google Site Kit, GetPaid/Invoicing plugin) behind Cloudflare. The site is a veteran-owned junk removal business serving the Denver metro area with **47 public URLs**: 12 pages, 14 service pages, and 21 blog posts (plus the blog index).

Unlike the copestpros rebuild, this site's baseline SEO hygiene is decent — Yoast provides real title tags, meta descriptions, canonicals, Open Graph tags, and Organization/BreadcrumbList schema on every page. **The rebuild's job is to preserve that equity exactly while fixing the issues below and expanding local reach.**

### Critical findings

| Issue | Severity | Detail |
|-------|----------|--------|
| **Client invoices exposed in public sitemap** | Critical (privacy) | `wpi_invoice-sitemap.xml` lists **205 invoice URLs** (`/invoice/invoice-######/`), submitted to Google via the sitemap index. Last invoice: Aug 18, 2026 — the invoicing system is actively used. These must be removed from the sitemap, noindexed, and killed in the rebuild. |
| Payment/quote pages set to index | High | `/your-quotes/`, `/gp-invoices/`, `/gp-subscriptions/`, `/online-payment/` + receipt/failure pages are all `index,follow`. Utility pages should be noindex. |
| No LocalBusiness schema | High | Yoast outputs generic `Organization` schema. A junk removal company needs `LocalBusiness` (or `MovingCompany`/`HomeAndConstructionBusiness`) with service area, hours, phone, and geo for local pack signals. |
| Lorem ipsum meta description | Medium | `/get-started/` ships a Lorem-ipsum meta description to Google. |
| No FAQ schema | Medium | No FAQ rich-result opportunities captured on any service page. |
| No city/service-area pages | High | Only implicit "Denver" targeting. Competitors rank with dedicated pages for Lakewood, Aurora, Littleton, Arvada, Westminster, etc. (One blog post targets Lakewood.) |
| Old-tech dependency | Info | Site depends on Gravity Forms + GetPaid for lead capture, quotes, invoicing, and payments — all of this is functional scope the Laravel app must replace (see §6). |

---

## 1. Current Site Audit

### Tech stack
- **CMS:** WordPress 7.0.4, Uncode theme + rounded-digital child theme
- **SEO:** Yoast SEO (full meta + schema graph + XML sitemaps)
- **Forms:** Gravity Forms (+ GA event tracking add-on)
- **Billing:** GetPaid / WP Invoicing plugin (quotes, invoices, online payment)
- **Analytics:** Google Site Kit, gtag container `GT-MQB8X74N`
- **CDN:** Cloudflare
- **Host behavior:** non-www canonical; http→https 301; no-trailing-slash → trailing-slash 301; proper 404s

### URL structure (must be preserved)
- Pages: `/about/`, `/contact/`, `/services/`, `/get-started/`, `/blog/`, `/online-payment/`
- Services (custom post type): `/services/{slug}/` — 14 pages, e.g. `/services/furniture-removal-services/`
- Blog posts: **category-prefixed permalinks** — `/cleanout/{slug}/` (10), `/removal/{slug}/` (10), `/outside-cleanup/{slug}/` (1)
- All URLs use trailing slashes. The Laravel app must serve trailing-slash URLs with 200 (not 301 them away) or 301 consistently to a single canonical — do **not** create redirect chains.

### Content depth
- Service pages: 690–1,000 words each (adequate, can be expanded)
- Blog posts: 1,000–1,900 words each (solid)
- Full inventory with per-URL title/meta/schema: see `OLD-SITE-URL-INVENTORY.md` and `url-catalog.json`

---

## 2. URL Mapping & Redirect Plan

**Principle: 1:1 URL preservation. Zero redirects needed for the 43 indexed content URLs.**

| Old URL pattern | New site | Action |
|-----------------|----------|--------|
| `/` , `/about/`, `/contact/`, `/services/`, `/get-started/`, `/blog/` | Same path | 200, same content improved |
| `/services/{slug}/` (14) | Same path | 200, same title/meta baseline |
| `/cleanout/{slug}/`, `/removal/{slug}/`, `/outside-cleanup/{slug}/` (21) | Same path | 200, migrate post content verbatim |
| `/invoice/invoice-*/` (205) | — | **410 Gone** (or 404). Remove from sitemap. Request removal in Search Console. |
| `/your-quotes/`, `/gp-invoices/`, `/gp-subscriptions/` | New customer portal (if kept) | 301 to new equivalent or 410; noindex either way |
| `/online-payment/`, `/online-payment/gp-receipt/`, `/online-payment/gp-transaction-failed/` | New payment flow | 301 to new equivalent; noindex |
| `/wp-content/uploads/*` (images) | Keep serving or 301 to new asset paths | Images rank in Google Images; avoid mass-breaking them |
| `/feed/`, `/comments/feed/` | 301 to `/blog/` or serve RSS | Low priority |
| `/wp-json/*`, `/wp-login.php`, `/xmlrpc.php` | 404/410 | Kill WP attack surface |

**Sitemap:** new Laravel-generated `sitemap.xml` containing ONLY the 43 content URLs (pages + services + posts). Submit in Search Console on launch day.

---

## 3. New Site Architecture (Laravel 12 + Vue 3 + Inertia)

Same architecture as the copestpros rebuild:

- `Service` model → `/services/{slug}/` (14 seeded from WP export)
- `BlogPost` model with `category_prefix` column (`cleanout` | `removal` | `outside-cleanup`) → `/{prefix}/{slug}/`
- Static Inertia pages: Home, About, Contact, Services index, Get Started, Blog index
- `FormSubmissionController` for quote/contact forms (replaces Gravity Forms)
- `SitemapController` for dynamic sitemap.xml
- Per-page SEO component: title, meta description, canonical, OG/Twitter tags, JSON-LD

### Schema upgrades (net-new SEO value)
- `LocalBusiness` on every page: name, phone `+1-720-999-0941`, areaServed (Denver metro), veteran-owned attribute via `slogan`/description, geo, openingHours
- `Service` schema on each service page
- `FAQPage` schema on service pages (write 4–6 FAQs each)
- `BlogPosting` + `BreadcrumbList` on posts (preserve Yoast's breadcrumb structure)

### Growth phase (post-launch)
- City pages: `/junk-removal-{city}-co/` for Lakewood, Aurora, Littleton, Arvada, Westminster, Centennial, Englewood, Thornton (mirrors the copestpros city-page strategy)
- Continue the seasonal blog cadence already established (spring cleaning, fall prep, holiday appliance posts)

---

## 4. Technical SEO Requirements (launch blockers)

1. Every indexed URL from `OLD-SITE-URL-INVENTORY.md` returns 200 with equal-or-better title/meta
2. Trailing-slash policy matches old site (no redirect chains)
3. non-www + https canonical preserved (Cloudflare stays in front)
4. `robots.txt`: allow all content, disallow admin/api paths
5. XML sitemap with real `lastmod` dates carried over from WP `modified` timestamps
6. 301/410 map from §2 implemented as Laravel routes/middleware
7. gtag `GT-MQB8X74N` (or client's GA4 property) carried over
8. Fix Lorem-ipsum meta on `/get-started/`
9. Core Web Vitals: beat the WP/Uncode baseline (heavy theme — easy win)
10. Images: preserve `/wp-content/uploads/` paths or map old→new with 301s

---

## 5. Launch Checklist

- [ ] Crawl new site with same cataloger; diff against `url-catalog.json` — zero missing URLs
- [ ] Verify 410 on all `/invoice/*` URLs
- [ ] Submit new sitemap.xml in Search Console; remove old sitemap references
- [ ] Search Console: URL removal request for `/invoice/*` prefix
- [ ] Verify LocalBusiness schema in Rich Results Test
- [ ] Confirm form submissions deliver (email + DB record)
- [ ] Monitor GSC coverage + rankings daily for 2 weeks post-launch

---

## 6. Open Scope Question — Invoicing & Payments (needs Brandon/client decision)

The WP site is not just brochure-ware: the client actively runs **quotes → invoices → online payments** through the GetPaid plugin (205 invoices, most recent Aug 18, 2026). The rebuild must answer:

- **Option A:** Rebuild quote/invoice/payment flow in Laravel (Stripe invoices or Laravel Cashier + a small customer portal) — keeps everything on one platform
- **Option B:** Move billing to a third-party (Stripe invoicing, Square, QuickBooks) and drop the on-site portal — simplest, kills the privacy leak permanently
- **Option C:** Keep WP alive on a subdomain temporarily for billing only — not recommended (maintains WP attack surface)

Either way, existing invoice URLs must stop being publicly accessible and indexed.

---

## 7. Risk Mitigation

| Risk | Mitigation |
|------|-----------|
| Ranking loss from missed URL | 1:1 URL preservation + pre-launch diff against `url-catalog.json` |
| Broken image SEO | Preserve `/wp-content/uploads/` paths in Laravel `public/` |
| Invoice URLs cached by Google | 410 + Search Console removal + verify with `site:milehighhauloff.com/invoice` |
| Client loses billing mid-transition | Decide §6 before launch; do not cut over until replacement flow tested |
| Trailing-slash redirect chains | Explicit route-level handling, verified in launch checklist |
