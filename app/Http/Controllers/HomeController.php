<?php

namespace App\Http\Controllers;

use App\Models\Album;

class HomeController extends Controller
{
    public function index()
    {
        $albums = Album::select('id')->get();
        $grid = collect([]);

        while ($grid->count() < 150) {
            $grid = $grid->concat($albums);
        }

        $grid = $grid->shuffle()->values();

        return inertia('index', ['albums' => $grid]);
    }

    public function settings()
    {
        return inertia('settings');
    }
}
