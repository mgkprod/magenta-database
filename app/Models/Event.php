<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $appends = [
        'image_url',
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    public function getImageUrlAttribute()
    {
        return optional($this->getFirstMedia('images'))->getFullUrl();
    }
}
