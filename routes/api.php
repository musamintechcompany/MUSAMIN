<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Emoji API
Route::get('/emojis/categories', [App\Http\Controllers\EmojiController::class, 'getCategories']);
Route::get('/emojis/search', [App\Http\Controllers\EmojiController::class, 'search']);
Route::get('/emojis/popular', [App\Http\Controllers\EmojiController::class, 'getPopular']);



// TODO: Add API routes when building mobile app
