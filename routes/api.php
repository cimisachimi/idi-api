<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\GalleryController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('testimonials', TestimonialController::class);
    Route::apiResource('galleries', GalleryController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});

// Public endpoint (landing page)
Route::get('public/galleries', [GalleryController::class, 'index']);


Route::get('public/testimonials', [TestimonialController::class, 'index']);