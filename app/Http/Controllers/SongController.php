<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        return inertia('songs/index', compact('songs'));
    }

    public function create()
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'announced' => 'Annoncé',
            'published' => 'Publié',
        ];

        $types = [
            'original' => 'Originale',
            'remix' => 'Remix',
            'live' => 'Live',
            'concert' => 'Concert',
        ];

        return inertia('songs/create', compact('types', 'availabilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
        ]);

        $song = new Song();
        $song->title = $request->title;
        $song->alt_title = $request->alt_title;
        $song->artist = $request->artist;
        $song->type = $request->type;
        $song->availability = $request->availability;
        $song->released_at = $request->released_at;
        $song->first_time_played_at = $request->first_time_played_at;
        $song->variant_agg = $request->variant_agg;
        $song->details = $request->details;
        $song->save();

        if ($request->file('image')) {
            $song
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('songs.show', $song);
    }

    public function show(Song $song)
    {
        $song->load(['albums', 'events']);

        $variants = $song
            ->variants
            ->where('id', '!=', $song->id);

        if (count($variants) == 0) {
            $variants = null;
        }

        $medias = $song->getMedia('medias');

        foreach ($medias as $media) {
            $media->url = $media->getUrl();
        }

        return inertia('songs/show', compact('song', 'medias', 'variants'));
    }

    public function edit(Song $song)
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'announced' => 'Annoncé',
            'published' => 'Publié',
        ];

        $types = [
            'original' => 'Originale',
            'remix' => 'Remix',
            'live' => 'Live',
            'concert' => 'Concert',
        ];

        return inertia('songs/edit', compact('song', 'availabilities', 'types'));
    }

    public function update(Request $request, Song $song)
    {
        $request->validate([
            'title' => ['required'],
        ]);

        $song->title = $request->title;
        $song->alt_title = $request->alt_title;
        $song->artist = $request->artist;
        $song->type = $request->type;
        $song->availability = $request->availability;
        $song->released_at = $request->released_at;
        $song->first_time_played_at = $request->first_time_played_at;
        $song->variant_agg = $request->variant_agg;
        $song->details = $request->details;

        if ($request->file('image')) {
            $song
                ->clearMediaCollection('images');

            $song
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        $song->save();

        return redirect()->route('songs.show', $song);
    }

    public function editRelations(Song $song)
    {
        $albums = Album::pluck('name', 'id');
        $events = Event::pluck('name', 'id');

        $album_ids = $song->albums->pluck('id');
        $event_ids = $song->events->pluck('id');

        return inertia('songs/edit/relations', compact('song', 'album_ids', 'event_ids', 'albums', 'events'));
    }

    public function updateRelations(Request $request, Song $song)
    {
        $song->albums()->sync($request->album_ids);
        $song->events()->sync($request->event_ids);

        return redirect()->route('songs.index');
    }

    public function createFile(Song $song)
    {
        return inertia('songs/files/create', compact('song'));
    }

    public function storeFile(Request $request, Song $song)
    {
        if ($request->file('audio')) {
            $media = $song
                ->addMediaFromRequest('audio')
                ->withCustomProperties(['source' => $request->source])
                ->toMediaCollection('medias');

            $probe = FFProbe::create()
                ->streams($media->getPath())
                ->audios()
                ->first();

            foreach ([
                'codec_name',
                'sample_rate',
                'channels',
                'duration',
                'bit_rate',
                'bits_per_raw_sample',
                'bits_per_sample',
            ] as $property) {
                $media->setCustomProperty($property, $probe->get($property));
            }

            $media->save();
        }

        return redirect()->route('songs.show', $song);
    }

    public function destroyFile(Request $request, Song $song, Media $media)
    {
        $media->delete();

        return redirect()->route('songs.show', $song);
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('songs.index');
    }
}
