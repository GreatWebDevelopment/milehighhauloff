<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'site' => [
                'name' => config('site.name'),
                'phone' => config('site.phone'),
                'phoneDisplay' => config('site.phone_display'),
                'email' => config('site.email'),
                'serviceAreas' => config('site.service_areas'),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
        ];
    }
}
