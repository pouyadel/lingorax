<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title_fa', 'title_en',
        'slug',
        'excerpt_fa', 'excerpt_en',
        'content_fa', 'content_en',
        'level', 'category', 'read_time',
        'image', 'is_published'
    ];

    protected $casts = ['is_published' => 'boolean'];
}