<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Album extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasUlid;

    protected $guarded = [];

    protected $casts = [
        'released_at' => 'date',
    ];

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
