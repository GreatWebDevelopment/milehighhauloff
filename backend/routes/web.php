<?php

use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\SitemapController;
use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
 * URL structure mirrors the old WordPress site 1:1 (see ../SEO_TRANSITION_STRATEGY.md).
 * Blog posts keep their WP category-prefixed permalinks: /cleanout/*, /removal/*, /outside-cleanup/*.
 */

$seo = fn (string $title, string $description, array $extra = []) => array_merge([
    'title' => $title,
    'description' => $description,
], $extra);

// Home
Route::get('/', fn () => Inertia::render('Home', [
    'services' => Service::published()->orderBy('sort_order')->get(['slug', 'name', 'meta_description', 'og_image']),
    'seo' => [
        'title' => 'Professional Junk Removal & Yard Cleanup Services in Denver Metro Area | Mile High Haul-Off',
        'description' => 'Mile High Haul-Off is a veteran-owned junk removal service in Denver, CO, offering fast and reliable hauling for residential and commercial needs. From construction debris to old appliances, yard waste, furniture, and hoarder cleanouts, we provide eco-friendly, hassle-free solutions to keep your space clean and organized.',
    ],
]));

// Static pages
Route::get('/about', fn () => Inertia::render('About', [
    'seo' => [
        'title' => 'About Us | Mile High Haul-Off',
        'description' => 'Learn more about Mile High Haul-Off, a veteran-owned junk removal service in Denver, CO. Our team specializes in fast, reliable, and eco-friendly hauling for homes and businesses.',
    ],
]));

Route::get('/contact', fn () => Inertia::render('Contact', [
    'seo' => [
        'title' => 'Contact Us | Mile High Haul-Off',
        'description' => 'Contact Mile High Haul-Off for fast, reliable junk removal and yard cleanup services in the Denver area. Get a free quote today and experience hassle-free hauling.',
    ],
]));

Route::get('/get-started', fn () => Inertia::render('GetStarted', [
    'services' => Service::published()->orderBy('sort_order')->get(['slug', 'name']),
    'seo' => [
        'title' => 'Get Started | Mile High Haul-Off',
        'description' => 'Get started with Mile High Haul-Off in three easy steps: request your free quote, schedule a pickup, and let our veteran-owned Denver crew handle the heavy lifting.',
    ],
]));

// Services
Route::get('/services', fn () => Inertia::render('Services/Index', [
    'services' => Service::published()->orderBy('sort_order')->get(['slug', 'name', 'meta_description', 'og_image']),
    'seo' => [
        'title' => 'Services | Mile High Haul-Off',
        'description' => 'Mile High Haul-Off offers fast, reliable junk removal services in the Denver area. From construction debris and appliance removal to yard cleanups and full property cleanouts.',
    ],
]));

Route::get('/services/{service:slug}', fn (Service $service) => Inertia::render('Services/Show', [
    'service' => $service,
    'seo' => [
        'title' => $service->meta_title ?? $service->name.' | Mile High Haul-Off',
        'description' => $service->meta_description,
        'image' => $service->og_image,
        'schema' => 'service',
    ],
]))->missing(fn () => abort(404));

// Blog
Route::get('/blog', fn () => Inertia::render('Blog/Index', [
    'posts' => BlogPost::published()->orderByDesc('published_at')
        ->get(['slug', 'category', 'title', 'meta_description', 'og_image', 'published_at']),
    'seo' => [
        'title' => 'Blog | Mile High Haul-Off',
        'description' => 'Junk removal tips, cleanout guides, and seasonal advice for Denver homeowners and businesses from the Mile High Haul-Off team.',
    ],
]));

// Blog posts keep their WP category-prefixed URLs
Route::get('/{category}/{post:slug}', function (string $category, BlogPost $post) {
    abort_unless($post->category === $category && $post->is_published, 404);

    return Inertia::render('Blog/Show', [
        'post' => $post,
        'seo' => [
            'title' => $post->meta_title ?? $post->title.' | Mile High Haul-Off',
            'description' => $post->meta_description,
            'image' => $post->og_image,
            'schema' => 'article',
            'published' => $post->published_at?->toAtomString(),
            'modified' => $post->wp_modified?->toAtomString(),
        ],
    ]);
})->whereIn('category', ['cleanout', 'removal', 'outside-cleanup']);

// Form submissions (replaces Gravity Forms)
Route::post('/submit/quote', [FormSubmissionController::class, 'quote']);
Route::post('/submit/contact', [FormSubmissionController::class, 'contact']);

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

/*
 * Legacy WordPress URLs
 */

// GetPaid invoice pages: 205 client invoices were publicly exposed in the old
// sitemap. Gone permanently — also request removal in Search Console.
Route::any('/invoice/{any}', fn () => abort(410))->where('any', '.*');

// GetPaid billing/quote portal pages — billing replacement is an open scope
// decision (SEO_TRANSITION_STRATEGY.md §6); temporary redirect until decided.
foreach (['your-quotes', 'gp-invoices', 'gp-subscriptions', 'online-payment', 'online-payment/gp-receipt', 'online-payment/gp-transaction-failed'] as $legacy) {
    Route::get('/'.$legacy, fn () => redirect('/contact', 302));
}

// WP internals: hard 410 so crawlers drop them and scanners get nothing
foreach (['wp-login.php', 'xmlrpc.php', 'wp-admin/{any?}', 'wp-json/{any?}'] as $wp) {
    Route::any('/'.$wp, fn () => abort(410))->where('any', '.*');
}

// Old WP feeds
Route::get('/feed', fn () => redirect('/blog', 301));
Route::get('/comments/feed', fn () => redirect('/blog', 301));
