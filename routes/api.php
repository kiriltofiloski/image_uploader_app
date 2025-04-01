<?php

use App\Http\Controllers\UploadedImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api.token')->group(function () {
    Route::post('/upload', [UploadedImageController::class, 'store']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
