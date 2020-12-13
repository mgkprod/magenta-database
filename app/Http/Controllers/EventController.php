<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return inertia('events/index');
    }

    public function create()
    {
        return inertia('events/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // TODO
            'name' => ['required'],
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->save();
    }

    public function show(Event $event)
    {
        $event->with(['songs']);

        return inertia('events/show', compact('event'));
    }

    public function edit(Event $event)
    {
        return inertia('events/edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            // TODO
            'name' => ['required'],
        ]);

        $event->name = $request->name;
        $event->save();
    }

    public function destroy(Request $request, Event $event)
    {
        $event->delete();
    }
}
