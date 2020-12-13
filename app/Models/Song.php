<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Song extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    protected function events()
    {
        return $this->belongsToMany(self::class);
    }
}
