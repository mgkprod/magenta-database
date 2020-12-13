<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::get();

        return inertia('songs/index', compact('songs'));
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
            'title' => ['required'],
        ]);

        $song = new Song();
        $song->title = $request->title;
        $song->save();

        return redirect()->route('songs.index');
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
            'title' => ['required'],
        ]);

        $song->title = $request->title;
        $song->save();

        return redirect()->route('songs.index');
    }

    public function destroy(Request $request, Song $song)
    {
        $song->delete();

        return redirect()->route('songs.index');
    }
}
