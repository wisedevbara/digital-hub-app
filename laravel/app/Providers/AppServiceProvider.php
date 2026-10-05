<?php

namespace App\Providers;

use App\Http\Middleware\RequireActiveOidcToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Guard for pages that require a live IdP access token. Named so the
        // check is explicit at every route that depends on it.
        Route::middlewareGroup('oidc.token', [
            RequireActiveOidcToken::class,
        ]);
    }
}
