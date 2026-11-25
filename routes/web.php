<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AuthController;

Route::get('/', [PageController::class, 'accueil'])
    ->name('accueil');

Route::get('/a-propos', [PageController::class, 'aPropos'])
    ->name('a-propos');

Route::get('/contenus/tri/{tri?}', [ContenuController::class, 'index'])
    ->name('contenus.tri');

Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'create'])
        ->name('inscription');

    Route::post('/inscription', [AuthController::class, 'store'])
        ->name('inscription.store');

    Route::get('/connexion', [AuthController::class, 'createLogin'])
        ->name('login');

    Route::post('/connexion', [AuthController::class, 'login'])
        ->name('connexion.store');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('deconnexion');

Route::middleware('auth')->group(function () {
    Route::resource('contenus', ContenuController::class)
        ->parameters(['contenus' => 'contenu'])
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::resource('contenus', ContenuController::class)
    ->parameters(['contenus' => 'contenu'])
    ->only(['index', 'show']);

Route::get('/categories', [CategorieController::class, 'index'])
    ->name('categories.index');

Route::middleware(['auth', 'can:gerer-categories'])->group(function () {
    Route::resource('categories', CategorieController::class)
        ->except(['index', 'show']);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/tableau-de-bord', [AdminController::class, 'index'])
            ->name('dashboard');
    });

    Route::get(
    '/contenus/{contenu}/document-prive',
    [ContenuController::class, 'documentPrive']
)
    ->middleware('can:viewPrivateDocument,contenu')
    ->name('contenus.document-prive');

});

