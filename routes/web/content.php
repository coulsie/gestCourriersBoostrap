<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PostController,
    AnnonceController,
    ReponseController,
    RapportController
};

Route::middleware(['auth'])->group(function () {

    // --- 1. GESTION DES POSTS (ARTICLES) ---
    // Route spécifique protégée par permission
    Route::delete('/post/{id}', [PostController::class, 'destroy'])
        ->middleware('can:supprimer-articles')
        ->name('posts.destroy');


    // --- 2. ANNONCES & RÉPONSES ---
    // Ressource complète pour les annonces
    Route::resource('annonces', AnnonceController::class);

    // Groupe pour les réponses/commentaires
    Route::prefix('reponses')->name('reponses.')->group(function () {
        Route::post('/store', [ReponseController::class, 'store'])->name('store');
        Route::post('/{id}/valider', [ReponseController::class, 'valider'])->name('valider');
    });


    // --- 3. RAPPORTS & EXPORTS ---
    Route::prefix('rapports')->name('rapports.')->group(function () {
        // Vue mensuelle
        Route::get('/mensuel', [RapportController::class, 'mensuel'])->name('mensuel');

        // Export PDF (avec paramètres agent et période)
        Route::get('/export-pdf/{agent_id}/{periode}', [RapportController::class, 'exportPDF'])->name('export.pdf');
    });

});
