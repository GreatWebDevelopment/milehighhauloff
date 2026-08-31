<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $urls = [];

        $staticPages = [
            ['path' => '/', 'changefreq' => 'weekly', 'priority' => '1.0', 'lastmod' => null],
            ['path' => '/about', 'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => null],
            ['path' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => null],
            ['path' => '/get-started', 'changefreq' => 'monthly', 'priority' => '0.8', 'lastmod' => null],
            ['path' => '/services', 'changefreq' => 'weekly', 'priority' => '0.9', 'lastmod' => null],
            ['path' => '/blog', 'changefreq' => 'weekly', 'priority' => '0.8', 'lastmod' => null],
        ];

        foreach ($staticPages as $page) {
            $urls[] = $this->urlEntry($baseUrl.$page['path'], $page['changefreq'], $page['priority'], $page['lastmod']);
        }

        Service::published()->orderBy('sort_order')->get()->each(function ($service) use (&$urls, $baseUrl) {
            $urls[] = $this->urlEntry(
                $baseUrl.'/services/'.$service->slug,
                'monthly', '0.8',
                $service->wp_modified?->toAtomString()
            );
        });

        BlogPost::published()->orderByDesc('published_at')->get()->each(function ($post) use (&$urls, $baseUrl) {
            $urls[] = $this->urlEntry(
                $baseUrl.$post->url(),
                'monthly', '0.7',
                $post->wp_modified?->toAtomString()
            );
        });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
            .implode("\n", $urls)."\n"
            .'</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function urlEntry(string $loc, string $changefreq, string $priority, ?string $lastmod = null): string
    {
        $entry = "  <url>\n    <loc>".e($loc)."</loc>\n";
        if ($lastmod) {
            $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
        }
        $entry .= "    <changefreq>{$changefreq}</changefreq>\n    <priority>{$priority}</priority>\n  </url>";

        return $entry;
    }
}
