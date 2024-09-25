<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $topUsers = Cache::remember('top_followed_users', 60, function () {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])->get(env('SERVER_ENDPOINT') . '/api/topfollowed');

                if ($response->successful()) {
                    return $response->json()['data'];
                }

                return [];
            });

            $view->with('topUsers', $topUsers);
        });
    }
}
