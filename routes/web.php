<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\HomeController;

/*

|--------------------------------------------------------------------------
| 1. ACCÈS PUBLICS (INVITÉS)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome-login');
})->middleware('guest');

// AUTHENTIFICATION : On désactive 'reset' ici car vous le gérez dans web/auth.php
Auth::routes(['reset' => false]);

// CHARGEMENT DES ROUTES D'AUTH (Mot de passe oublié, Profil, etc.)
// On le place ICI pour que les routes 'guest' (forgot-password) fonctionnent
require __DIR__ . '/web/auth.php';

/*

|--------------------------------------------------------------------------
| 2. ROUTES PROTÉGÉES (UTILISATEURS CONNECTÉS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirection après connexion
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- MODULES ---
    require __DIR__ . '/web/organisation.php';
    require __DIR__ . '/web/hr.php';
    require __DIR__ . '/web/admin.php';
    require __DIR__ . '/web/content.php';
    require __DIR__ . '/web/reunions.php';

    // NOTE : J'ai supprimé le deuxième "require auth.php" qui était ici
    // et qui causait des doublons.

    /*

    |--------------------------------------------------------------------------
    | OPTIONNEL : MIDDLEWARE FORCE.PASSWORD
    |--------------------------------------------------------------------------
    */
    Route::middleware(['force.password'])->group(function () {
        // Vos routes spécifiques ici
    });
});
