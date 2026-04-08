<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminaireController;
use App\Http\Controllers\SeminaireParticipantController;

/*

|--------------------------------------------------------------------------
| MODULE SÉMINAIRES (Administration)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::prefix('seminaires')->name('seminaires.')->group(function () {

        // 1. STATISTIQUES & TABLEAUX DE BORD
        Route::get('/etat-global', [SeminaireController::class, 'dashboard'])->name('etat-global');

        // 2. GESTION DES DOCUMENTS & QR CODES
        Route::get('/{seminaire}/qrcode', [SeminaireController::class, 'showQrCode'])->name('qrcode');
        Route::get('/{seminaire}/qrcode-journalier', [SeminaireController::class, 'qrcodeJournalier'])->name('qrcodeJournalier');
        Route::post('/{seminaire}/documents', [SeminaireController::class, 'uploadDocument'])->name('documents.store');
        Route::delete('/{seminaire}/documents/{documentId}', [SeminaireController::class, 'deleteDocument'])->name('documents.destroy');

        // 3. GESTION DES PARTICIPANTS ET ÉMARGEMENT
        Route::prefix('/{seminaire}/participants')->group(function () {
            // Ajout de participants
            Route::post('/add-multiple', [SeminaireParticipantController::class, 'ajouterMultiplesAgents'])->name('add_multiple_agents');
            Route::post('/add-service', [SeminaireParticipantController::class, 'ajouterParService'])->name('add_service');
            Route::post('/add-externe', [SeminaireParticipantController::class, 'ajouterExterne'])->name('add_externe');

            // Émargement journalier (Table seminaire_emargements)
            Route::get('/emargement', [SeminaireController::class, 'showEmargement'])->name('emargement');
            Route::post('/{participantId}/update-emargement', [SeminaireController::class, 'updatePointage'])->name('update-emargement');

            // Pointage global (Table seminaire_participants)
            Route::post('/{participation}/pointer', [SeminaireParticipantController::class, 'pointerPresence'])->name('pointer');
            Route::post('/{participantId}/update-pointage', [SeminaireParticipantController::class, 'updatePointage'])->name('update-pointage');
        });

        // 4. CRUD STANDARD
        Route::get('/', [SeminaireController::class, 'index'])->name('index');
        Route::get('/create', [SeminaireController::class, 'create'])->name('create');
        Route::post('/', [SeminaireController::class, 'store'])->name('store');
        Route::get('/{seminaire}', [SeminaireController::class, 'show'])->name('show');
        Route::get('/{seminaire}/edit', [SeminaireController::class, 'edit'])->name('edit');
        Route::put('/{seminaire}', [SeminaireController::class, 'update'])->name('update');
        Route::delete('/{seminaire}', [SeminaireController::class, 'destroy'])->name('destroy');
    });
});

/*

|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (Scan Mobile)
|--------------------------------------------------------------------------
*/

Route::prefix('seminaires/public')->name('seminaires.public.')->group(function () {

    // Scan Global
    Route::get('/scan/{uuid}', [SeminaireController::class, 'scanEmargement'])->name('scan');
    Route::post('/scan/{uuid}/valider', [SeminaireController::class, 'validerEmargement'])->name('valider');

    // Scan Journalier (QR Code projeté)
    Route::get('/scan-journalier/{uuid}', [SeminaireController::class, 'public_emargeJournalier'])->name('emargeJournalier');
    Route::post('/scan-journalier/{uuid}/valider', [SeminaireController::class, 'validerEmargementJournalier'])->name('validerJournalier');
});
