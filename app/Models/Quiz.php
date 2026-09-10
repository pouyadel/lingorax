<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
    'title_fa', 'title_en', 'slug',
    'description_fa', 'description_en',
    'level', 'category', 'is_published'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }
}