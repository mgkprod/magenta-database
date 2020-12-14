<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $version = rescue(fn () => 'v' . trim(File::get(config_path('.version'))), 'WIP', false);
        $sha = rescue(fn () => ' (' . substr(File::get(base_path('REVISION')), 0, 7) . ')', null, false);
        $env = config('app.env') == 'production' ? '' : ' - ' . config('app.env');

        Inertia::share('version', $version . $sha . $env);

        URL::forceScheme('https');

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
