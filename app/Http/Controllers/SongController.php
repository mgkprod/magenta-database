<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        return redirect()->route('songs.browse', ['filter' => $request->input('filter', 'all')]);
    }

    public function browse($filter = null)
    {
        $filters = [
            'all' => ['name' => 'Tous', 'description' => 'Tous les tracks référencés'],
            'published' => ['name' => 'Publiés', 'description' => 'Tous les tracks officiels'],
            'published-lost' => ['name' => 'Publiés sans album', 'description' => 'Les tracks officiels qui ne sont pas dans à un album ou présent dans un event'],
            'unreleased' => ['name' => 'Inédits', 'description' => "Les tracks qui n'ont pas eu de release et qu'on a entendu qu'une fois"],
            'really-unreleased' => ['name' => 'Inédits, sans variantes', 'description' => "Les tracks qui n'ont pas eu de release officielle"],
            'deleted' => ['name' => 'Supprimés', 'description' => "Les tracks qui ont été publiés un jour et qui sont aujourd'hui retirés des plateformes"],
        ];

        if (! $filter || ! in_array($filter, array_keys($filters))) {
            return redirect()->route('songs.browse', ['filter' => 'all']);
        }

        $songs = Song::query();

        if ($filter == 'published') {
            // Published songs
            $songs = $songs->where('availability', 'published');
        }

        if ($filter == 'published-lost') {
            // Songs that does not belongs to an album nor an event
            $songs = $songs
                ->whereDoesntHave('albums')
                ->whereDoesntHave('events');
        }

        if ($filter == 'unreleased') {
            // Unreleased songs
            $songs = $songs->where('availability', 'unreleased');
        }

        if ($filter == 'really-unreleased') {
            // Unreleased songs, without variants
            $songs = $songs
                ->where('availability', 'unreleased')
                ->has('variants', '=', 1);
        }

        if ($filter == 'deleted') {
            // Delted songs
            $songs = $songs->where('availability', 'deleted');
        }

        $songs = $songs
            ->orderBy('first_time_played_at', 'DESC')
            ->orderBy('released_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return inertia('songs/index', [
            'songs' => $songs,
            'filters' => $filters,
            'current_filter' => $filter ?? 'all',
        ]);
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
        $song->is_downloadable = ($request->is_downloadable == 'true');
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
            ->where('id', '!=', $song->id)
            ->values();

        $medias = $song->getMedia('medias');
        $medias = Song::score($medias);

        foreach ($medias as $media) {
            $media->url = $media->getUrl();
        }

        $files = $song->getMedia('files');

        foreach ($files as $media) {
            $media->url = $media->getUrl();
        }

        return inertia('songs/show', compact('song', 'medias', 'files', 'variants'));
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
        $song->is_downloadable = ($request->is_downloadable == 'true');

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

    public function createMedia(Song $song)
    {
        $handle = uniqid();

        return inertia('songs/medias/create', compact('song', 'handle'));
    }

    public function storeMedia(Request $request, Song $song)
    {
        Storage::move('temp/' . $request->handle, 'temp/' . $request->file_name);

        $media = $song
            ->addMediaFromDisk('temp/' . $request->file_name)
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

        return redirect()->route('songs.show', $song);
    }

    public function destroyMedia(Request $request, Song $song, Media $media)
    {
        $media->delete();

        return redirect()->route('songs.show', $song);
    }

    public function createFile(Song $song)
    {
        $handle = uniqid();

        return inertia('songs/files/create', compact('song', 'handle'));
    }

    public function storeFile(Request $request, Song $song)
    {
        Storage::move('temp/' . $request->handle, 'temp/' . $request->file_name);

        $file = $song
            ->addMediaFromDisk('temp/' . $request->file_name)
            ->withCustomProperties(['name' => $request->name])
            ->toMediaCollection('files');

        return redirect()->route('songs.show', $song);
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('songs.index');
    }
}
