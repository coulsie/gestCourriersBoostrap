<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DirectionController, ServiceController, AgentServiceController,
    CourrierController, ImputationController, ActivityController
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
// --- GESTION DES FLUX (COURRIERS) ---
Route::prefix('courriers')->name('courriers.')->group(function () {
    Route::get('/', [CourrierController::class, 'index'])->name('index');
    Route::get('/create', [CourrierController::class, 'create'])->name('create');
    Route::post('/', [CourrierController::class, 'store'])->name('store');

    // --- ROUTES SPÉCIFIQUES ---
    Route::post('/{courrier}/unlock', [CourrierController::class, 'unlock'])->name('unlock');

    // --- AJOUT DE LA ROUTE D'ENVOI MAIL ICI ---
    Route::post('/{courrier}/send-mail', [CourrierController::class, 'sendMail'])->name('send-mail');

    Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
    Route::get('/recherche-avancee', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
});

// Gardez le resource pour les autres actions
Route::resource('courriers', CourrierController::class)->except(['index', 'create', 'store']);


// --- GESTION DES FLUX (IMPUTATIONS) ---
Route::prefix('imputations')->name('imputations.')->group(function () {
    // 1. Vos routes personnalisées (AVANT le resource)
    Route::get('/mes-imputations', [ImputationController::class, 'mesImputations'])->name('mes_imputations');
    Route::post('/check-interim', [ImputationController::class, 'checkInterim'])->name('check-interim');
});

// 2. Toutes les routes standards (index, create, store, show, edit, update, destroy)
Route::resource('imputations', ImputationController::class);


// Page d'accueil (Redirection)
Route::get('/', function () {
    return redirect()->route('activities.index');
});

// --- Groupe des Activités (CRUD) ---
Route::prefix('activites')->name('activities.')->group(function () {

    // Liste des saisies récentes (Index)
    Route::get('/', [ActivityController::class, 'index'])->name('index');

    // Formulaire de création
    Route::get('/saisie', [ActivityController::class, 'create'])->name('create');

    // Enregistrement
    Route::post('/', [ActivityController::class, 'store'])->name('store');

    // Consultation détaillée d'une activité spécifique (SHOW)
    Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');

    // Edition d'une saisie existante
    Route::get('/{activity}/modifier', [ActivityController::class, 'edit'])->name('edit');

    // Mise à jour (Update)
    Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');

    // Suppression
    Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');
});

// --- Groupe des Rapports & Synthèses ---
Route::get('/synthese', [ActivityController::class, 'synthese'])->name('activities.synthese');
