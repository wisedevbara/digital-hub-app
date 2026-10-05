<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OidcController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('dashboard'))->name('home');

// Entry point: kicks off the OIDC Authorization Code + PKCE flow.
Route::get('/login', [OidcController::class, 'redirect'])->name('login');

// The IdP redirects the browser here. Must be publicly reachable and must NOT
// sit behind the token middleware.
Route::get('/auth/callback', [OidcController::class, 'callback'])->name('auth.callback');

// Lets the Vue SPA recover the pending authorize query if its URL loses it.
Route::get('/auth/authorize-query', [OidcController::class, 'authorizeQuery'])
    ->name('auth.authorize-query');

/*
|--------------------------------------------------------------------------
| Authenticated - access-token liveness is enforced on every request
|--------------------------------------------------------------------------
*/

Route::middleware('oidc.token')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Liveness probe for the front end and manual checks.
    Route::get('/session/status', function (Illuminate\Http\Request $request) {
        $expiresAt = (int) $request->session()->get('oidc.expires_at', 0);

        return response()->json([
            'authenticated' => true,
            'user' => $request->user()?->only(['id', 'name', 'email', 'oidc_sub']),
            'scope' => $request->session()->get('oidc.scope'),
            'token_expires_at' => $expiresAt ?: null,
            'token_expires_in' => $expiresAt > 0 ? max(0, $expiresAt - time()) : null,
        ]);
    })->name('session.status');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [OidcController::class, 'logout'])->name('logout');
// Convenience for plain link-based navigation.
Route::get('/logout', [OidcController::class, 'logout'])->name('logout.get');