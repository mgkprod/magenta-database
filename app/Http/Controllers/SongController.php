<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        return inertia('songs/index');
    }

    public function create()
    {
        $albums = Album::get();
        $events = Event::get();

        return inertia('songs/create', compact('albums', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // TODO
            'title' => ['required'],
        ]);

        $song = new Song();
        $song->title = $request->title;
        $song->save();
    }

    public function show(Song $song)
    {
        $song->with(['albums', 'events']);

        return inertia('songs/show', compact('song'));
    }

    public function edit(Song $song)
    {
        $albums = Album::get();
        $events = Event::get();

        return inertia('songs/edit', compact('song', 'albums', 'events'));
    }

    public function update(Request $request, Song $song)
    {
        $request->validate([
            // TODO
            'title' => ['required'],
        ]);

        $song->title = $request->title;
        $song->save();
    }

    public function destroy(Request $request, Song $song)
    {
        $song->delete();
    }
}
