<?php

use App\Models\Album;
use App\Models\Event;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events/{event}/songs', function (Request $request, Event $event) {
    return response()->json(['songs' => $event->songs]);
});

Route::get('/albums/{album}/songs', function (Request $request, Album $album) {
    return response()->json(['songs' => $album->songs]);
});

Route::get('/songs/{song}/medias', function (Request $request, Song $song) {
    // Return all medias for $song. Only the best if $request->best is filled
    $medias = $song->getMedia('medias');
    $medias = Song::score($medias);

    foreach ($medias as $media) {
        $media->url = $media->getUrl();
    }

    if ($request->best) {
        return response()->json([
            'media' => $medias->first(),
        ]);
    }

    return response()->json([
        'medias' => $medias,
    ]);
});
