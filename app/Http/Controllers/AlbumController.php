<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $grouped_albums = Album::query()
            ->orderBy('released_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy('artist');

        return inertia('albums/index', compact('grouped_albums'));
    }

    public function create()
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'deleted' => 'Supprimé',
            'published' => 'Publié',
        ];

        $types = [
            'ep' => 'Ep',
            'single' => 'Single',
            'album' => 'Album',
            'mixtape' => 'Mixtape',
        ];

        return inertia('albums/create', compact('types', 'availabilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->artist = $request->artist;
        $album->released_at = $request->released_at;
        $album->type = $request->type;
        $album->availability = $request->availability;
        $album->details = $request->details;
        $album->save();

        if ($request->file('image')) {
            $album
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('albums.index');
    }

    public function show(Album $album)
    {
        $album->load(['songs']);

        $files = $album->getMedia('files');

        foreach ($files as $media) {
            $media->url = $media->getUrl();
        }

        return inertia('albums/show', compact('album', 'files'));
    }

    public function edit(Album $album)
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'deleted' => 'Supprimé',
            'published' => 'Publié',
        ];

        $types = [
            'ep' => 'Ep',
            'single' => 'Single',
            'album' => 'Album',
            'mixtape' => 'Mixtape',
        ];

        return inertia('albums/edit', compact('availabilities', 'types', 'album'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $album->name = $request->name;
        $album->artist = $request->artist;
        $album->released_at = $request->released_at;
        $album->type = $request->type;
        $album->availability = $request->availability;
        $album->details = $request->details;
        $album->save();

        if ($request->file('image')) {
            $album
                ->clearMediaCollection('images');

            $album
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('albums.index');
    }

    public function createFile(Album $album)
    {
        $handle = uniqid();

        return inertia('albums/files/create', compact('album', 'handle'));
    }

    public function storeFile(Request $request, Album $album)
    {
        Storage::move('temp/' . $request->handle, 'temp/' . $request->file_name);

        $file = $album
            ->addMediaFromDisk('temp/' . $request->file_name)
            ->withCustomProperties(['name' => $request->name])
            ->toMediaCollection('files');

        return redirect()->route('albums.show', $album);
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('albums.index');
    }
}
