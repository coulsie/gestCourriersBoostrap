<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DirectionController, ServiceController, AgentServiceController,
    CourrierController, ImputationController
};

// --- 1. AFFECTATIONS & SERVICES (À METTRE EN HAUT DU FICHIER) ---
Route::prefix('agents')->name('agents.')->group(function () {
    // Ces routes doivent être définies AVANT le resource 'agents' qui est dans hr.php
    Route::match(['get', 'post'], '/par-service', [AgentServiceController::class, 'listeParService'])->name('par.service');
    Route::match(['get', 'post'], '/par-service/recherche', [AgentServiceController::class, 'recherche'])->name('par.service.recherche');
});

// --- 2. STRUCTURE HIÉRARCHIQUE ---
Route::resource('directions', DirectionController::class);
Route::resource('services', ServiceController::class);



// --- 3. FLUX DE TRAVAIL (COURRIERS & IMPUTATIONS) ---
// --- GESTION DES FLUX (COURRIERS) ---
Route::prefix('courriers')->name('courriers.')->group(function () {
    Route::get('/', [CourrierController::class, 'index'])->name('index');
    Route::get('/create', [CourrierController::class, 'create'])->name('create');
    Route::post('/', [CourrierController::class, 'store'])->name('store');

    // --- LES ROUTES SPÉCIFIQUES APPELÉES PAR VOTRE MENU ---
    Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
    Route::get('/recherche-avancee', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
});

// Gardez le resource pour les autres actions (show, edit, update, destroy)
Route::resource('courriers', CourrierController::class)->except(['index', 'create', 'store']);


// --- GESTION DES FLUX (IMPUTATIONS) ---
Route::prefix('imputations')->name('imputations.')->group(function () {
    // 1. Vos routes personnalisées (AVANT le resource)
    Route::get('/mes-imputations', [ImputationController::class, 'mesImputations'])->name('mes_imputations');
    Route::post('/check-interim', [ImputationController::class, 'checkInterim'])->name('check-interim');
});

// 2. Toutes les routes standards (index, create, store, show, edit, update, destroy)
Route::resource('imputations', ImputationController::class);
