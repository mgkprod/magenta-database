<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Song extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasUlid;

    protected $guarded = [];

    protected $casts = [
        'released_at' => 'date',
        'first_time_played_at' => 'date',
    ];

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
