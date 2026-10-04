<?php

use App\Http\Controllers\AuthentikCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- Authentik OIDC (authorization code flow) ---
Route::get('/auth/callback', [AuthentikCallbackController::class, 'show'])
    ->name('auth.callback');
Route::get('/auth/authorize-url', [AuthentikCallbackController::class, 'authorizeUrl'])
    ->name('auth.authorize-url');
