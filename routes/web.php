<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;

Route::get('/', [PageController::class, 'accueil'])
    ->name('accueil');

Route::get('/a-propos', [PageController::class, 'aPropos'])
    ->name('a-propos');

Route::get('/contenus/tri/{tri?}', [ContenuController::class, 'index'])
    ->name('contenus.tri');

Route::resource('contenus', ContenuController::class);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get(
        '/tableau-de-bord',
        [AdminController::class, 'index']
    )->name('dashboard');
});

Route::get('/categories', [CategorieController::class, 'index'])
    ->name('categories.index');
    