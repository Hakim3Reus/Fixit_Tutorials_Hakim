<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['step_id', 'url'];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}

