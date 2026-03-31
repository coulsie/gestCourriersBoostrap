<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AgentController, PresenceController, AbsenceController,
    TypeAbsenceController, HolidayController, InterimController
};

// --- 1. AGENTS & TABLEAU DE BORD ---

// Placez ces routes AVANT le resource
Route::prefix('agents')->name('agents.')->group(function () {
    Route::get('/nouveau', [AgentController::class, 'nouveau'])->name('nouveau');
    Route::post('/enregistrer', [AgentController::class, 'Enr'])->name('enregistrer');
});

Route::get('/tableau-de-bord', [AgentController::class, 'dashb'])->name('agent.dashboard');
Route::resource('agents', AgentController::class);



// --- 2. PRÉSENCES & POINTAGES ---
Route::prefix('presences')->name('presences.')->group(function () {
    Route::get('/mon-pointage', [PresenceController::class, 'monPointage'])->name('monPointage');
    Route::post('/mon-pointage/enregistrer', [PresenceController::class, 'enregistrerPointage'])->name('enregistrerPointage');
    Route::get('/mon-historique', [PresenceController::class, 'monHistorique'])->name('monHistorique');
    Route::get('/liste-filtree', [PresenceController::class, 'listeFiltree'])->name('listeFiltree');
    Route::get('/validation-hebdo', [PresenceController::class, 'indexValidationHebdo'])->name('validation-hebdo');
    Route::post('/valider-hebdo', [PresenceController::class, 'storeValidationHebdo'])->name('valider-hebdo');
    Route::get('/etat', [PresenceController::class, 'statsPresences'])->name('etat');
    Route::get('/stats', [PresenceController::class, 'stats'])->name('etatperiodique');
});
Route::get('/rapports/presences/periodique', [PresenceController::class, 'rapport'])->name('rapports.presences.periodique');
Route::resource('presences', PresenceController::class);

// --- 3. ABSENCES & CONGÉS ---
Route::prefix('absences')->name('absences.')->group(function () {
    Route::get('/mon-autorisation', [AbsenceController::class, 'monautorisation'])->name('monautorisation');
    Route::get('/mes-absences', [AbsenceController::class, 'indexAutorisation'])->name('indexAutorisation');
    Route::post('/monstore', [AbsenceController::class, 'monstore'])->name('monstore');
    Route::post('/check-overlap', [AbsenceController::class, 'checkOverlap'])->name('checkOverlap');
    Route::get('/pdf/{id}', [AbsenceController::class, 'genererPdf'])->name('genererPdf');
    Route::get('/imprimer/{absence}', [AbsenceController::class, 'print'])->name('print');
    Route::get('/admin/create', [AbsenceController::class, 'createListe'])->name('createListe');
    Route::post('/admin-store', [AbsenceController::class, 'store'])->name('store');
    Route::post('/store-grouped', [AbsenceController::class, 'storeGrouped'])->name('storeGrouped');
    Route::post('/ma-demande', [AbsenceController::class, 'storeAutorisationAbsence'])->name('storeAutorisation');
});

Route::middleware(['role:admin|rh|Superviseur'])->group(function () {
    Route::get('/absences/validations', [AbsenceController::class, 'validationListe'])->name('absences.validation_liste');
    Route::post('/absences/approuver/{id}', [AbsenceController::class, 'approuver'])->name('absences.approuver');
    Route::get('/chef/validations', [AbsenceController::class, 'indexChef'])->name('chef.absences.index');
    Route::post('/chef/valider/{absence}', [AbsenceController::class, 'valider'])->name('chef.absences.valider');
    Route::post('/absences/rejeter/{id}', [AbsenceController::class, 'rejeter'])->name('chef.absences.rejeter');
});

Route::resource('absences', AbsenceController::class);
Route::resource('typeabsences', TypeAbsenceController::class);
Route::resource('holidays', HolidayController::class);
Route::patch('/interims/{interim}/stop', [InterimController::class, 'stop'])->name('interims.stop');
Route::resource('interims', InterimController::class);
