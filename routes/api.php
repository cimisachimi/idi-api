<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);

// --- Authentication Routes ---
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// --- Protected Routes (Require Authentication) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Use `except` to prevent creating redundant GET routes
    Route::apiResource('galleries', GalleryController::class)->except(['index']);
    Route::apiResource('testimonials', TestimonialController::class)->except(['index']);
});