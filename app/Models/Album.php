<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    protected function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
