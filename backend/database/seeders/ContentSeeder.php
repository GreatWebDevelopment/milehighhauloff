<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $services = json_decode(file_get_contents(database_path('seeders/data/services.json')), true);
        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], [
                'name' => $s['name'],
                'meta_title' => $s['meta_title'],
                'meta_description' => $s['meta_description'],
                'content' => $s['content'],
                'og_image' => $s['og_image'] ?? null,
                'sort_order' => $s['sort_order'],
                'is_published' => true,
                'wp_modified' => $s['wp_modified'] ?? null,
            ]);
        }

        $posts = json_decode(file_get_contents(database_path('seeders/data/blog_posts.json')), true);
        foreach ($posts as $p) {
            BlogPost::updateOrCreate(['slug' => $p['slug']], [
                'category' => $p['category'],
                'title' => $p['title'],
                'meta_title' => $p['meta_title'],
                'meta_description' => $p['meta_description'],
                'content' => $p['content'],
                'og_image' => $p['og_image'] ?? null,
                'is_published' => true,
                'published_at' => $p['published_at'] ?? null,
                'wp_modified' => $p['wp_modified'] ?? null,
            ]);
        }
    }
}
