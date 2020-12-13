<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        return inertia('albums/index');
    }

    public function create()
    {
        return inertia('albums/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // TODO
            'name' => ['required'],
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->save();
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
            // TODO
            'name' => ['required'],
        ]);

        $album->name = $request->name;
        $album->save();
    }

    public function destroy(Request $request, Album $album)
    {
        $album->delete();
    }
}
