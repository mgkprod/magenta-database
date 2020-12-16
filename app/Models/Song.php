<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use Rorecek\Ulid\HasUlid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Song extends Model implements HasMedia, Searchable
{
    use InteractsWithMedia;
    use HasUlid;

    protected $guarded = [];

    protected $casts = [
        'released_at' => 'date',
        'first_time_played_at' => 'date',
        'is_downloadable' => 'boolean',
    ];

    protected $appends = [
        'display_title',
        'version_name',
        'image_dominant_color',
        'image_url',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function variants()
    {
        return $this->hasMany(self::class, 'variant_agg', 'variant_agg');
    }

    public function getDisplayTitleAttribute()
    {
        if ($this->version_name) {
            return $this->title . ' (' . $this->version_name . ')';
        }

        return $this->title;
    }

    public function getVersionNameAttribute()
    {
        if ($this->type == 'original') {
            return null;
        }

        if ($this->type == 'clip') {
            return 'Clip officiel';
        }

        $types = [
            'remix' => 'Remix',
            'rework' => 'Rework',
            'live' => 'Live',
            'radio-edit' => 'Radio Edit',
            'live-rework' => 'Live Rework',
            'extended-mix' => 'Extended Mix',
        ];

        if ($this->events->first()) {
            return $types[$this->type] . ' @ ' . $this->events->first()->name;
        } else {
            return $types[$this->type];
        }

        return null;
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

        $palette = Palette::fromFilename($image->getPath());
        $extractor = new ColorExtractor($palette);
        $dominant = Color::fromIntToHex($extractor->extract()[0]);

        $image->setCustomProperty('dominant_color', $dominant);
        $image->save();

        return $dominant;
    }

    public static function score($medias)
    {
        $codec_names = [
            'flac' => 15,
            'opus' => 15,
            'mp3' => 5,
            'aac' => 5,
        ];

        foreach ($medias as $media) {
            $score = 0;

            // Format
            foreach ($codec_names as $codec_name => $weight) {
                if ($media->getCustomProperty('codec_name') == $codec_name) {
                    $score += $weight;
                }
            }

            if ($media->hasCustomProperty('bit_rate')) {
                if ($media->getCustomProperty('bit_rate') >= 300000) {
                    $score += 5;
                } // > 300kbps (320)
                elseif ($media->getCustomProperty('bit_rate') >= 200000) {
                    $score += 3;
                } // > 200kbps (256)
                elseif ($media->getCustomProperty('bit_rate') >= 100000) {
                    $score += 1;
                } // > 100kbps (128)
            }

            $media->score = $score;
        }

        return $medias
            ->sortByDesc('score')
            ->values();
    }

    public function getSearchResult(): SearchResult
    {
        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->display_title,
            route('songs.show', $this)
         );
    }
}
