<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
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

Route::resource('songs', SongController::class);
Route::get('songs/{song}/edit/relations', [SongController::class, 'editRelations'])->name('songs.edit-relations');
Route::put('songs/{song}/relations', [SongController::class, 'updateRelations'])->name('songs.update-relations');

Route::get('songs/{song}/files/create', [SongController::class, 'createFile'])->name('songs.files.create');
Route::post('songs/{song}/files', [SongController::class, 'storeFile'])->name('songs.files.store');
Route::delete('songs/{song}/files/{media}', [SongController::class, 'destroyFile'])->name('songs.files.destroy');

Route::resource('albums', AlbumController::class);
Route::resource('events', EventController::class);

Route::group(['middleware' => 'auth'], function () {
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);
