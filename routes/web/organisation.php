<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DirectionController, ServiceController, AgentServiceController,
    CourrierController, ImputationController, ActivityController
};

/*

|--------------------------------------------------------------------------
| 1. AFFECTATIONS & SERVICES
|--------------------------------------------------------------------------
*/
Route::prefix('agents')->name('agents.')->group(function () {
    Route::match(['get', 'post'], '/par-service', [AgentServiceController::class, 'listeParService'])->name('par.service');
    Route::match(['get', 'post'], '/par-service/recherche', [AgentServiceController::class, 'recherche'])->name('par.service.recherche');
});

/*

|--------------------------------------------------------------------------
| 2. STRUCTURE HIÉRARCHIQUE
|--------------------------------------------------------------------------
*/
Route::resource('directions', DirectionController::class);
Route::resource('services', ServiceController::class);

/*

|--------------------------------------------------------------------------
| 3. FLUX DE TRAVAIL (COURRIERS & IMPUTATIONS)
|--------------------------------------------------------------------------
*/
Route::prefix('courriers')->name('courriers.')->group(function () {
    Route::get('/', [CourrierController::class, 'index'])->name('index');
    Route::get('/create', [CourrierController::class, 'create'])->name('create');
    Route::post('/', [CourrierController::class, 'store'])->name('store');
    Route::post('/{courrier}/unlock', [CourrierController::class, 'unlock'])->name('unlock');
    Route::post('/{courrier}/send-mail', [CourrierController::class, 'sendMail'])->name('send-mail');
    Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
    Route::get('/recherche-avancee', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
});

Route::resource('courriers', CourrierController::class)->except(['index', 'create', 'store']);

Route::prefix('imputations')->name('imputations.')->group(function () {
    Route::get('/mes-imputations', [ImputationController::class, 'mesImputations'])->name('mes_imputations');
    Route::post('/check-interim', [ImputationController::class, 'checkInterim'])->name('check-interim');
});

Route::resource('imputations', ImputationController::class);

/*

|--------------------------------------------------------------------------
| 4. GESTION DES ACTIVITÉS (PROTÉGÉ PAR AUTH)
|--------------------------------------------------------------------------
*/

/*

|--------------------------------------------------------------------------
| 4. GESTION DES ACTIVITÉS (PROTÉGÉ PAR AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::prefix('activites')->name('activities.')->group(function () {
        // Liste & Synthèse
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/synthese', [ActivityController::class, 'synthese'])->name('synthese'); // Ajout de la route de synthèse

        // Création
        Route::get('/saisie', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');

        // Actions spécifiques (ID)
        Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
        Route::get('/{activity}/modifier', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
    });
});
