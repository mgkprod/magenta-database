<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\StaticPage;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'settings']);
    }

    public function index()
    {
        $albums = Album::select('id')->get();
        $grid = collect([]);

        while ($grid->count() < 150) {
            $grid = $grid->concat($albums);
        }

        $grid = $grid->shuffle()->values();

        return inertia('about', [
            'content' => StaticPage::firstWhere('slug', 'home')->content,
            'albums' => $grid,
        ]);
    }

    public function settings()
    {
        return inertia('settings');
    }
}
