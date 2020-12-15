<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->q;

        if ($q) {
            $results = (new Search())
                ->registerModel(Song::class, 'title')
                ->registerModel(Album::class, 'name')
                ->registerModel(Event::class, 'name')
                ->search($q)
                ->groupBy('type');

            // Flatten searchable
            foreach ($results as $model => $chunk) {
                foreach ($chunk as $id => $result) {
                    $results[$model][$id] = $result->searchable;
                }
            }
        } else {
            $results = [];
        }

        return inertia('search/index', compact('q', 'results'));
    }
}
