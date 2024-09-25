<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $topUsers = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get(env('SERVER_ENDPOINT') . '/api/topfollowed');
            $view->with('topUsers', $topUsers->json()['data']);
        });
    }
}
