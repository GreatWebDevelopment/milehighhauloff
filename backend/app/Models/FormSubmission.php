<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'type', 'name', 'email', 'phone', 'service', 'message', 'photos', 'payload',
    ];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'payload' => 'array',
        ];
    }
}
