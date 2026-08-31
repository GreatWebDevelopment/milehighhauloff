<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug', 'name', 'meta_title', 'meta_description', 'content',
        'og_image', 'sort_order', 'is_published', 'wp_modified',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'wp_modified' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
