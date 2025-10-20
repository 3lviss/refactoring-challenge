<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessTokenController;

Route::get('/', function() {
    return response()->json(['message' => 'Welcome']);
});

Route::get('/test', function() {
    return response()->json(['test' => 'works']);
});

Route::get('/token/{token}/{permission?}', AccessTokenController::class)
    ->defaults('permission', 'read')
    ->name('tokens.check');
