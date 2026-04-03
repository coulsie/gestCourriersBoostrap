<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;


/*

|--------------------------------------------------------------------------
| 1. ACCÈS PUBLICS / ACCUEIL (ACCESSIBLE APRÈS DÉCONNEXION)
|--------------------------------------------------------------------------
*/

// La racine affiche la page de bienvenue sans restriction
Route::get('/', function () {
    return view('welcome-login');
})->name('welcome');



// AUTHENTIFICATION DE BASE (Désactive le reset par défaut de Laravel UI)
Auth::routes(['reset' => false]);

// ✅ RÉTABLISSEMENT DES ROUTES "MOT DE PASSE OUBLIÉ" (Une seule fois ici)
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// CHARGEMENT DES ROUTES D'AUTH (Profil, Signature, etc.)
require __DIR__ . '/web/auth.php';

/*

|--------------------------------------------------------------------------
| 2. ESPACE SÉCURISÉ (AUTHENTIFICATION REQUISE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirection après connexion réussie (Le Dashboard)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- CHARGEMENT DES MODULES ---
    require __DIR__ . '/web/organisation.php';
    require __DIR__ . '/web/hr.php';
    require __DIR__ . '/web/admin.php';
    require __DIR__ . '/web/content.php';
    require __DIR__ . '/web/reunions.php';
    require __DIR__ . '/web/seminaires.php';

    /*

    |--------------------------------------------------------------------------
    | OPTIONNEL : PROTECTION CHANGEMENT DE MOT DE PASSE FORCÉ
    |--------------------------------------------------------------------------
    */
    Route::middleware(['force.password'])->group(function () {
        //
    });
});
