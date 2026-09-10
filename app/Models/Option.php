<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['question_id', 'text_fa', 'text_en', 'is_correct', 'order'];

    protected $casts = [
        'is_correct' => 'boolean',
    ];
}