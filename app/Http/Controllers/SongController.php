<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = [
            'unreleased',
            'really-unreleased',
            'lost',
        ];

        $request->validate([
            'filter' => ['nullable', Rule::in($filters)],
        ]);

        $songs = Song::query();

        if ($request->filter == 'unreleased') {
            // Unreleased songs
            $songs = $songs->where('availability', 'unreleased');
        }

        if ($request->filter == 'really-unreleased') {
            // Unreleased songs, without variants
            $songs = $songs
                ->where('availability', 'unreleased')
                ->has('variants', '=', 1);
        }

        if ($request->filter == 'lost') {
            // Songs that does not belongs to an album nor an event
            $songs = $songs
                ->whereDoesntHave('albums')
                ->whereDoesntHave('events');
        }

        $songs = $songs
            ->orderBy('first_time_played_at', 'DESC')
            ->orderBy('released_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return inertia('songs/index', compact('songs'));
    }

    public function create()
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'deleted' => 'Supprimé',
            'published' => 'Publié',
        ];

        $types = [
            'original' => 'Originale',
            'clip' => 'Clip',
            'remix' => 'Remix',
            'extended-mix' => 'Extended Mix',
            'live-rework' => 'Live Rework',
            'rework' => 'Rework',
            'live' => 'Live',
            'radio-edit' => 'Radio Edit',
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
        $medias = Song::score($medias)->sortByDesc('score');

        foreach ($medias as $media) {
            $media->url = $media->getUrl();
        }

        return inertia('songs/show', compact('song', 'medias', 'variants'));
    }

    public function edit(Song $song)
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'deleted' => 'Supprimé',
            'published' => 'Publié',
        ];

        $types = [
            'original' => 'Originale',
            'clip' => 'Clip',
            'remix' => 'Remix',
            'extended-mix' => 'Extended Mix',
            'live-rework' => 'Live Rework',
            'rework' => 'Rework',
            'live' => 'Live',
            'radio-edit' => 'Radio Edit',
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

            $probe = FFProbe::create([
                'ffmpeg.binaries' => config('services.ffmpeg.ffmpeg_path'),
                'ffprobe.binaries' => config('services.ffmpeg.ffprobe_path'),
            ])
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
