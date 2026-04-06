<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminaireController;
use App\Http\Controllers\SeminaireParticipantController;

/*

|--------------------------------------------------------------------------
| MODULE SÉMINAIRES (Protégé par Authentification)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::prefix('seminaires')->name('seminaires.')->group(function () {

        // 1. STATISTIQUES & TABLEAUX DE BORD (Priorité aux routes statiques)
        Route::get('/etat-global', [SeminaireController::class, 'dashboard'])->name('etat-global');

        // 2. GESTION DES DOCUMENTS
        Route::post('/{seminaire}/documents', [SeminaireController::class, 'uploadDocument'])->name('documents.store');
        Route::delete('/{seminaire}/documents/{documentId}', [SeminaireController::class, 'deleteDocument'])->name('documents.destroy');

        // 3. GESTION DES PARTICIPANTS (Inscriptions & Émargement)
        Route::prefix('/{seminaire}/participants')->group(function () {
            // Inscriptions
            Route::post('/add-multiple', [SeminaireParticipantController::class, 'ajouterMultiplesAgents'])->name('add_multiple_agents');
            Route::post('/add-service', [SeminaireParticipantController::class, 'ajouterParService'])->name('add_service');
            Route::post('/add-externe', [SeminaireParticipantController::class, 'ajouterExterne'])->name('add_externe');

            // Émargement & Pointage
            Route::get('/emargement', [SeminaireController::class, 'showEmargement'])->name('emargement');
            Route::post('/{participation}/pointer', [SeminaireParticipantController::class, 'pointerPresence'])->name('pointer');
            Route::post('/{participation}/update-pointage', [SeminaireParticipantController::class, 'updatePointage'])->name('update-pointage');
        });

        // 4. CRUD STANDARD (Toujours en dernier pour éviter les conflits d'ID)
        Route::get('/', [SeminaireController::class, 'index'])->name('index');
        Route::get('/create', [SeminaireController::class, 'create'])->name('create');
        Route::post('/', [SeminaireController::class, 'store'])->name('store');
        Route::get('/{seminaire}', [SeminaireController::class, 'show'])->name('show');
        Route::get('/{seminaire}/edit', [SeminaireController::class, 'edit'])->name('edit');
        Route::put('/{seminaire}', [SeminaireController::class, 'update'])->name('update');
        Route::delete('/{seminaire}', [SeminaireController::class, 'destroy'])->name('destroy');
    });
});
