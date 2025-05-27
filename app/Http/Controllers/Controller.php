<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Inertia::share([
            'auth' => function () {
                return [
                    'user' => auth()->user(),
                ];
            },
            'errors' => function () {
                return session('errors') ? session('errors')->getBag('default')->getMessages() : (object) [];
            },
        ]);
    }
}
