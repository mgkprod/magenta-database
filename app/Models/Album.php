<?php

namespace App\Models;

use ColorThief\ColorThief;
use Illuminate\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Album extends Model implements HasMedia, Searchable
{
    use HasUlid;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'released_at' => 'datetime',
    ];

    protected $appends = [
        'image_dominant_color',
        'image_url',
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMedia('images')
            ? $this->getFirstMedia('images')->getFullUrl()
            : url('images/default.jpg');
    }

    public function getImageDominantColorAttribute()
    {
        if (! $image = $this->getFirstMedia('images')) {
            return '#260166';
        }

        if ($image->hasCustomProperty('dominant_color')) {
            return $image->getCustomProperty('dominant_color');
        }

        $dominant = ColorThief::getColor($image->getPath(), 10, null, 'hex');
        $image->setCustomProperty('dominant_color', $dominant);
        $image->save();

        return $dominant;
    }

    public function getSearchResult(): SearchResult
    {
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            route('albums.show', $this)
        );
    }
}
