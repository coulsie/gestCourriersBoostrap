<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordSetupController;

/*

|--------------------------------------------------------------------------
| ROUTES PUBLIQUES / INVITÉS (GUEST)
|--------------------------------------------------------------------------

| Ces routes sont accessibles uniquement si l'utilisateur n'est pas connecté.
*/
Route::middleware('guest')->group(function () {
    // Configuration initiale du mot de passe
    Route::get('/password/setup', [PasswordSetupController::class, 'show'])->name('password.setup');
    Route::post('/password/setup', [PasswordSetupController::class, 'update'])->name('password.setup.update');
});

/*
|--------------------------------------------------------------------------
| ROUTES AUTHENTIFIÉES (AUTH)

|--------------------------------------------------------------------------
| Le middleware 'auth' garantit que si la session expire après X minutes
| d'inactivité, l'utilisateur est automatiquement redirigé vers /login.
*/
Route::middleware(['auth'])->group(function () {

    // Gestion du Profil (Regroupé pour assurer la protection)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');

        // Route de mise à jour (Correction : placée sous protection auth)
        Route::match(['put', 'post', 'patch'], '/update', [ProfileController::class, 'update'])->name('update');

        // Signature
        Route::get('/signature/edit', [ProfileController::class, 'editSignature'])->name('signature.edit');
        Route::post('/signature/update', [ProfileController::class, 'updateSignature'])->name('signature.update');
    });

    // Changement de mot de passe depuis le profil
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])
        ->name('user.password.custom.update');

    /*
       CONSEIL : Si vous avez d'autres fichiers de routes (ex: absences.php),
       assurez-vous de les inclure ICI ou de les protéger par le middleware 'auth'
       dans web.php pour que l'inactivité fonctionne partout.
    */
});
