<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // 1. État des réunions sur une période (Recherche et Filtres)
    // Placé avant le resource pour éviter que 'etat' ne soit confondu avec un ID
    Route::get('/reunions/etat', [MeetingController::class, 'etat'])->name('reunions.etat');

    // 2. Vue calendrier ou liste hebdomadaire
    Route::get('/reunions/hebdo', [MeetingController::class, 'hebdo'])->name('reunions.hebdo');

    // 3. Ressources standards (index, create, store, show, edit, update, destroy)
    Route::resource('reunions', MeetingController::class);
    // Ajoutez cette ligne
    Route::get('/reunions/{reunion}/liste-presence', [MeetingController::class, 'listePresence'])->name('reunions.liste_presence');

});
