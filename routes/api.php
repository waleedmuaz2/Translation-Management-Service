<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TranslationController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('translations')->group(function () {
        Route::get('/', [TranslationController::class, 'index']);
        Route::post('/', [TranslationController::class, 'store']);
        Route::get('/search', [TranslationController::class, 'search']);
        Route::get('/export', [TranslationController::class, 'export']);
        Route::put('/{translation}', [TranslationController::class, 'update']);
        Route::delete('/{translation}', [TranslationController::class, 'destroy']);
        
        // Tag management for translations
        Route::post('/{translation}/tags/{tag}', [TranslationController::class, 'attachTag']);
        Route::delete('/{translation}/tags/{tag}', [TranslationController::class, 'detachTag']);
    });

    // Tag routes
    Route::prefix('tags')->group(function () {
        Route::get('/', [TagController::class, 'index']);
        Route::post('/', [TagController::class, 'store']);
        Route::delete('/{tag}', [TagController::class, 'destroy']);
    });

    // Language routes
    Route::prefix('languages')->group(function () {
        Route::get('/', [LanguageController::class, 'index']);
        Route::post('/', [LanguageController::class, 'store']);
        Route::put('/{language}', [LanguageController::class, 'update']);
        Route::delete('/{language}', [LanguageController::class, 'destroy']);
    });

    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Fallback for undefined routes
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});