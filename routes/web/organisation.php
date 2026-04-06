<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DirectionController,
    ServiceController,
    AgentServiceController,
    CourrierController,
    ImputationController,
    ActivityController

};

/*

|--------------------------------------------------------------------------
| 1. STRUCTURE & AGENTS (ACCÈS GÉNÉRAL)
|--------------------------------------------------------------------------
*/

Route::resource('directions', DirectionController::class);
Route::resource('services', ServiceController::class);

Route::prefix('agents')->name('agents.')->group(function () {
    Route::match(['get', 'post'], '/par-service', [AgentServiceController::class, 'listeParService'])->name('par.service');
    Route::match(['get', 'post'], '/par-service/recherche', [AgentServiceController::class, 'recherche'])->name('par.service.recherche');
});

/*

|--------------------------------------------------------------------------
| 2. FLUX DE TRAVAIL (COURRIERS & IMPUTATIONS)
|--------------------------------------------------------------------------
*/
Route::prefix('courriers')->name('courriers.')->group(function () {
    Route::get('/', [CourrierController::class, 'index'])->name('index');
    Route::get('/create', [CourrierController::class, 'create'])->name('create');
    Route::post('/', [CourrierController::class, 'store'])->name('store');
    Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
    Route::get('/recherche-avancee', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
    Route::post('/{courrier}/unlock', [CourrierController::class, 'unlock'])->name('unlock');
    Route::post('/{courrier}/send-mail', [CourrierController::class, 'sendMail'])->name('send-mail');
});
Route::resource('courriers', CourrierController::class)->except(['index', 'create', 'store']);

Route::prefix('imputations')->name('imputations.')->group(function () {
    Route::get('/mes-imputations', [ImputationController::class, 'mesImputations'])->name('mes_imputations');
    Route::post('/check-interim', [ImputationController::class, 'checkInterim'])->name('check-interim');
});
Route::resource('imputations', ImputationController::class);

/*

|--------------------------------------------------------------------------
| 3. ESPACE PROTÉGÉ (AUTHENTIFICATION REQUISE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- MODULE ACTIVITÉS ---
    Route::prefix('activites')->name('activities.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/synthese', [ActivityController::class, 'synthese'])->name('synthese');
        Route::get('/reporting', [ActivityController::class, 'reporting'])->name('reporting');
        Route::get('/saisie', [ActivityController::class, 'create'])->name('create');
        Route::post('/', [ActivityController::class, 'store'])->name('store');
        Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
        Route::get('/{activity}/modifier', [ActivityController::class, 'edit'])->name('edit');
        Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
        Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
    });

});
