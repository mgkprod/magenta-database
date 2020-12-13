<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $guarded = [];

    protected function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    protected function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
