<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\PublicationController;
use Illuminate\Support\Facades\Route;

Route::post('/connexion', [AuthController::class, 'connecter']);

Route::get('/categories', [CategorieController::class, 'index']);

Route::apiResource('publications', PublicationController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('publications', PublicationController::class)
        ->except(['index', 'show']);
});