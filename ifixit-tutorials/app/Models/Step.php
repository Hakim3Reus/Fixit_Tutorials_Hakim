<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = ['tutorial_id', 'instructions', 'translated_instructions', 'order'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}

