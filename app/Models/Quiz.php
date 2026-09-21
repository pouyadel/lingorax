<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title_fa',
        'title_en',
        'slug',
        'description_fa',
        'description_en',
        'category',
        'level',
        'is_published',
        'is_private',
        'password',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_private' => 'boolean',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}