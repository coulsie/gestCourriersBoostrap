<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminaireController;
use App\Http\Controllers\SeminaireParticipantController;

/*

|--------------------------------------------------------------------------
| GESTION DES DOCUMENTS (SÉMINAIRES)
|--------------------------------------------------------------------------

| Ces routes doivent être placées AVANT le resource pour éviter les conflits d'URL.
*/
Route::post('/seminaires/{id}/documents', [SeminaireController::class, 'uploadDocument'])
    ->name('seminaires.documents.store');

Route::delete('/seminaires/{id}/documents/{documentId}', [SeminaireController::class, 'deleteDocument'])
    ->name('seminaires.documents.destroy');

/*
|--------------------------------------------------------------------------
| GESTION DES PARTICIPANTS ET ÉMARGEMENT

|--------------------------------------------------------------------------
*/
Route::prefix('seminaires/{seminaire}/participants')->group(function () {

    // 1. Inscriptions (Ajout de personnes)
    Route::post('/add-multiple', [SeminaireParticipantController::class, 'ajouterMultiplesAgents'])
        ->name('seminaires.add_multiple_agents');

    Route::post('/add-service', [SeminaireParticipantController::class, 'ajouterParService'])
        ->name('seminaires.add_service');

    Route::post('/add-externe', [SeminaireParticipantController::class, 'ajouterExterne'])
        ->name('seminaires.add_externe');

    // 2. Émargement
    Route::post('/{participation}/pointer', [SeminaireParticipantController::class, 'pointerPresence'])
        ->name('seminaires.pointer');
});

/*
|--------------------------------------------------------------------------
| GESTION DES SÉMINAIRES (CRUD)
|--------------------------------------------------------------------------
*/
Route::get('/seminaires/etat-global', [SeminaireController::class, 'dashboard'])->name('seminaires.report');

Route::resource('seminaires', SeminaireController::class);
