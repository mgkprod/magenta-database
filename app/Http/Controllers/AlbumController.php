<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::get();

        return inertia('albums/index', compact('albums'));
    }

    public function create()
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'announced' => 'Annoncé',
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

        return inertia('albums/show', compact('album'));
    }

    public function edit(Album $album)
    {
        $availabilities = [
            'unreleased' => 'Inédit',
            'announced' => 'Annoncé',
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

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('albums.index');
    }
}
