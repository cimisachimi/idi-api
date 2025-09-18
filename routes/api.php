<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\GalleryController;

// Authentication Routes
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Protected API Resources
    Route::apiResource('testimonials', TestimonialController::class);
    Route::apiResource('galleries', GalleryController::class);
});

// Public API Endpoints
Route::get('public/galleries', [GalleryController::class, 'index']);
Route::get('public/testimonials', [TestimonialController::class, 'index']);