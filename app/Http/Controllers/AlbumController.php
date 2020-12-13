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
        return inertia('albums/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->released_at = $request->released_at;
        $album->save();

        return redirect()->route('albums.index');
    }

    public function show(Album $album)
    {
        $album->with(['songs']);

        return inertia('albums/show', compact('album'));
    }

    public function edit(Album $album)
    {
        return inertia('albums/edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $album->name = $request->name;
        $album->released_at = $request->released_at;
        $album->save();

        return redirect()->route('albums.index');
    }

    public function destroy(Request $request, Album $album)
    {
        $album->delete();

        return redirect()->route('albums.index');
    }
}
