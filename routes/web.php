<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

Route::resource('songs', SongController::class, ['except' => 'show']);
Route::get('songs/{song}/edit/relations', [SongController::class, 'editRelations'])->name('songs.edit-relations');
Route::put('songs/{song}/relations', [SongController::class, 'updateRelations'])->name('songs.update-relations');
Route::get('songs/{song}/medias/create', [SongController::class, 'createMedia'])->name('songs.medias.create');
Route::post('songs/{song}/medias', [SongController::class, 'storeMedia'])->name('songs.medias.store');
Route::delete('songs/{song}/medias/{media}', [SongController::class, 'destroyMedia'])->name('songs.medias.destroy');
Route::get('songs/{song}/files/create', [SongController::class, 'createFile'])->name('songs.files.create');
Route::post('songs/{song}/files', [SongController::class, 'storeFile'])->name('songs.files.store');

Route::get('songs/{song}', [SongController::class, 'show'])->where('song', '.{26}')->name('songs.show');
Route::get('songs/browse/{filter?}', [SongController::class, 'browse'])->name('songs.browse');

Route::resource('albums', AlbumController::class);
Route::get('albums/{album}/files/create', [AlbumController::class, 'createFile'])->name('albums.files.create');
Route::post('albums/{album}/files', [AlbumController::class, 'storeFile'])->name('albums.files.store');

Route::resource('events', EventController::class);
Route::get('events/{event}/files/create', [EventController::class, 'createFile'])->name('events.files.create');
Route::post('events/{event}/files', [EventController::class, 'storeFile'])->name('events.files.store');

Route::post('files/chunk', [FileController::class, 'storeChunk'])->name('files.store.chunk');
Route::delete('files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

Route::get('files/{file}/convert', [FileController::class, 'showConvertForm'])->name('files.showConvertForm');
Route::post('files/{file}/convert', [FileController::class, 'convert'])->name('files.convert');

Route::get('search', SearchController::class)->name('search.index');

Route::group(['middleware' => 'auth'], function () {
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);
