<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users:create', function () {
    $this->info('Creating new user');

    $user = new User();
    $user->name = $this->ask('Name ?', null);
    $user->email = $this->ask('Email ?', null);
    $user->password = Hash::make($this->secret('Password ?'));
    $user->email_verified_at = now();
    $user->remember_token = Str::random(10);
    $user->save();

    $this->line('User created with id: '.$user->id);
});

Artisan::command('storage:purge {--dry-run}', function () {
    $this->info('Purging storage directory');
    $dry = $this->option('dry-run');

    $directories = collect(Storage::disk(config('media-library.disk_name'))->allDirectories());
    $medias = \Spatie\MediaLibrary\MediaCollections\Models\Media::pluck('id');

    $this->table(
        ['In storage', 'In database', 'To delete'],
        [[$directories->count(), $medias->count(), $directories->diff($medias)->count()]]
    );

    // List files names to delete for confirmation
    $directoriesToDelete = $directories->diff($medias);

    $this->info('Files to delete:');
    foreach ($directoriesToDelete as $directory) {
        collect(Storage::disk(config('media-library.disk_name'))->allFiles($directory))
            ->each(function ($file) {
                $this->line($file);
            });
    }

    if ($dry) {
        return $this->info('Dry run, nothing will be deleted.');
    }

    if (! $this->confirm('Do you want to delete these files ?')) {
        return $this->info('Aborted');
    }

    $this->info('Deleting files');

    $directoriesToDelete->each(function ($directory) {
        $this->info('Deleting '.$directory);
        Storage::disk(config('media-library.disk_name'))->delete($directory);
    });

    $this->info('Storage directory purged');
})->purpose('Remove all files from storage directory that are not in the database');

Artisan::command('storage:purge-temp', function () {
    $this->info('Purging temporary directory');
    $directory = storage_path('app/temp');
    $files = collect(Storage::allFiles($directory));

    // Delete all files that are older than 1 day
    $filesToDelete = $files->filter(function ($file) {
        return Storage::lastModified($file) < now()->subDay();
    });

    $this->table(
        ['In temporary directory', 'To delete'],
        [[$files->count(), $filesToDelete->count()]]
    );

    $this->info('Files to delete:');
    $filesToDelete->each(function ($file) {
        $this->line($file);
    });

    if (! $this->confirm('Do you want to delete these files ?')) {
        return $this->info('Aborted');
    }

    $this->info('Deleting files');

    $filesToDelete->each(function ($file) {
        $this->info('Deleting '.$file);
        Storage::delete($file);
    });

    $this->info('Temporary directory purged');
})->purpose('Remove all files from temporary directory');
