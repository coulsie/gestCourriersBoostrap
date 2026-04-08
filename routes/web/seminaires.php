<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminaireController;
use App\Http\Controllers\SeminaireParticipantController;

/*

|--------------------------------------------------------------------------
| MODULE SÉMINAIRES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::prefix('seminaires')->name('seminaires.')->group(function () {

        // 1. STATISTIQUES & TABLEAUX DE BORD
        Route::get('/etat-global', [SeminaireController::class, 'dashboard'])->name('etat-global');

        // 2. GESTION DES DOCUMENTS & QR CODE
        Route::get('/{seminaire}/qrcode', [SeminaireController::class, 'showQrCode'])->name('qrcode'); // <--- BIEN PLACÉ ICI
        Route::post('/{seminaire}/documents', [SeminaireController::class, 'uploadDocument'])->name('documents.store');
        Route::delete('/{seminaire}/documents/{documentId}', [SeminaireController::class, 'deleteDocument'])->name('documents.destroy');

        // 3. GESTION DES PARTICIPANTS
        Route::prefix('/{seminaire}/participants')->group(function () {
            Route::post('/add-multiple', [SeminaireParticipantController::class, 'ajouterMultiplesAgents'])->name('add_multiple_agents');
            Route::post('/add-service', [SeminaireParticipantController::class, 'ajouterParService'])->name('add_service');
            Route::post('/add-externe', [SeminaireParticipantController::class, 'ajouterExterne'])->name('add_externe');



            Route::get('/emargement', [SeminaireController::class, 'showEmargement'])->name('emargement');
            Route::post('/{participation}/pointer', [SeminaireParticipantController::class, 'pointerPresence'])->name('pointer');
           
             // Dans le groupe Route::prefix('/{seminaire}/participants')
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
| ROUTES PUBLIQUES (Scan QR Code)
|--------------------------------------------------------------------------
*/
Route::get('/seminaires/scan/{uuid}', [SeminaireController::class, 'scanEmargement'])->name('seminaires.public.scan');
Route::post('/seminaires/scan/{uuid}/valider', [SeminaireController::class, 'validerEmargement'])->name('seminaires.public.valider');
// Modifiez la ligne de scan en bas du fichier :
Route::get('/seminaires/scan/{id}', [SeminaireController::class, 'scanEmargement'])->name('seminaires.public.scan');
