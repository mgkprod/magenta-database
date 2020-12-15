<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

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

        return inertia('events/show', compact('event'));
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

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
