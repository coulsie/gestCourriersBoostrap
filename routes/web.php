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

// Routes d'authentification de base (Login, Logout, etc.)

Auth::routes(['reset' => false]);

/*

|--------------------------------------------------------------------------
| 2. MODULE D'AUTHENTIFICATION & PROFIL
|--------------------------------------------------------------------------
*/
require __DIR__.'/web/auth.php';

/*

|--------------------------------------------------------------------------
| 3. ROUTES PROTÉGÉES (UTILISATEURS CONNECTÉS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Redirection après connexion
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- TOUS VOS MODULES FRAGMENTÉS ---
    require __DIR__.'/web/organisation.php';

    // 2. ENSUITE les RH (qui contient le resource 'agents' général)
    require __DIR__.'/web/hr.php';

    // 3. LE RESTE
    require __DIR__.'/web/auth.php';
    require __DIR__.'/web/admin.php';
    require __DIR__.'/web/content.php';
    require __DIR__.'/web/reunions.php';


    /*

    |--------------------------------------------------------------------------
    | OPTIONNEL : MIDDLEWARE FORCE.PASSWORD
    |--------------------------------------------------------------------------
    */
    Route::middleware(['force.password'])->group(function () {
        // Ajoutez ici les routes qui nécessitent un changement de mot de passe forcé
    });

});
