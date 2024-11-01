<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $events = Event::query()
            ->orderBy('happened_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        return inertia('events/index', compact('events'));
    }

    public function create()
    {
        return inertia('events/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->happened_at = $request->happened_at;
        $event->details = $request->details;
        $event->save();

        if ($request->file('image')) {
            $event
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('events.index');
    }

    public function show(Event $event)
    {
        $event->load(['songs']);

        $files = $event->getMedia('files');

        foreach ($files as $media) {
            $media->url = $media->getUrl();
        }

        return inertia('events/show', compact('event', 'files'));
    }

    public function edit(Event $event)
    {
        return inertia('events/edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $event->name = $request->name;
        $event->happened_at = $request->happened_at;
        $event->details = $request->details;
        $event->save();

        if ($request->file('image')) {
            $event
                ->clearMediaCollection('images');

            $event
                ->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('events.index');
    }

    public function createFile(Event $event)
    {
        $handle = uniqid();

        return inertia('events/files/create', compact('event', 'handle'));
    }

    public function storeFile(Request $request, Event $event)
    {
        Storage::move('temp/'.$request->handle, 'temp/'.$request->file_name);

        $file = $event
            ->addMediaFromDisk('temp/'.$request->file_name)
            ->withCustomProperties(['name' => $request->name])
            ->toMediaCollection('files');

        return redirect()->route('events.show', $event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }

    public function export(Event $event)
    {
        $zip = new ZipArchive();
        $zipFileName = storage_path('app/public/'.$event->name.'.zip');

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $allTracks = $event->songs->count();
            $trackNumber = 1;

            foreach ($event->songs as $song) {
                $outputPath = 'temp/'.$event->name.'/'.$trackNumber.' - '.$song->title.'.mp3';
                $song->track_number = $trackNumber.'/'.$allTracks;

                $song->export($outputPath);
                $zip->addFile(storage_path('app/'.$outputPath), $trackNumber.' - '.$song->title.'.mp3');
                $trackNumber++;
            }

            $zip->close();
        }

        foreach ($event->songs as $song) {
            $outputPath = 'temp/'.$event->name.'/'.$trackNumber.' - '.$song->title.'.mp3';
            Storage::delete($outputPath);
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
