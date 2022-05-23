<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        return parent::handle($request, $next)->setCache([
            'no_cache' => true,
            'no_store' => true,
            'must_revalidate' => true,
            'private' => true,
        ]);
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $ziggy = new Ziggy($group = null, $request->url());

        return array_merge(parent::share($request), [
            'ziggy' => $ziggy->toArray(),
            'app_name' => fn () => config('app.name'),
            'user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'errors' => fn () => $this->sharedValidationErrors($request),
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'warning' => $request->session()->get('warning'),
                'error' => $request->session()->get('error'),
            ],
        ]);
    }

    /**
     * Resolve shared validation errors.
     *
     * @return \Illuminate\Contracts\Support\MessageBag|\stdClass
     */
    protected function sharedValidationErrors($request)
    {
        if ($errors = $request->session()->get('errors')) {
            return $errors->getBag('default');
        }

        return new \stdClass;
    }
}
