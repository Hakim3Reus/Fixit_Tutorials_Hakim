<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = ['title', 'description', 'category', 'original_content'];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
}
