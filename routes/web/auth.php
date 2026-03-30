<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProfileController};
use App\Http\Controllers\Auth\{PasswordSetupController, ForgotPasswordController};

/*

|--------------------------------------------------------------------------
| ROUTES PUBLIQUES / INVITÉS (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Mot de passe oublié
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Configuration initiale du mot de passe
    Route::get('/password/setup', [PasswordSetupController::class, 'show'])->name('password.setup');
    Route::post('/password/setup', [PasswordSetupController::class, 'update'])->name('password.setup.update');
});

/*

|--------------------------------------------------------------------------
| ROUTES AUTHENTIFIÉES (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- CETTE ROUTE DOIT AVOIR CE NOM PRÉCIS POUR VOTRE MODAL ---
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])
        ->name('user.password.custom.update');

    // GROUPE PROFIL
    Route::prefix('profile')->name('profile.')->group(function () {

        // Gestion de base du profil
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/create', [ProfileController::class, 'create'])->name('create');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::match(['put', 'post', 'patch'], '/update', [ProfileController::class, 'update'])->name('update');

        // Gestion de la Signature
        Route::get('/signature', [ProfileController::class, 'signature'])->name('signature');
        Route::get('/signature/edit', [ProfileController::class, 'editSignature'])->name('signature.edit');
        Route::post('/signature/update', [ProfileController::class, 'updateSignature'])->name('signature.update');
    });
});
