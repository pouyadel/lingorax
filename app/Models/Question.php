<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'text_fa', 'text_en', 'order'];

    public function options()
    {
        return $this->hasMany(Option::class)->orderBy('order');
    }
}