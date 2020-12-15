<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Event extends Model implements HasMedia, Searchable
{
    use InteractsWithMedia;
    use HasUlid;

    protected $guarded = [];

    protected $casts = [
        'happened_at' => 'date',
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
        return $this->getFirstMedia('images')
            ? $this->getFirstMedia('images')->getFullUrl()
            : url('images/default.jpg');
    }

    public function getSearchResult(): SearchResult
    {
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            route('events.show', $this)
         );
    }
}
