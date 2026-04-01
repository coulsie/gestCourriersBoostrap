<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\{PasswordSetupController};

/*

|--------------------------------------------------------------------------
| ROUTES PUBLIQUES / INVITÉS (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // ⚠️ SUPPRIMEZ LES ROUTES 'forgot-password' ICI (Elles sont déjà dans Auth::routes())

    // Gardez uniquement votre logique spécifique
    Route::get('/password/setup', [PasswordSetupController::class, 'show'])->name('password.setup');
    Route::post('/password/setup', [PasswordSetupController::class, 'update'])->name('password.setup.update');
});

/*

|--------------------------------------------------------------------------
| ROUTES AUTHENTIFIÉES (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // ... Gardez le reste de votre code (Profil, Signature, etc.) ...
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])
        ->name('user.password.custom.update');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/signature/edit', [ProfileController::class, 'editSignature'])->name('signature.edit');
        Route::post('/signature/update', [ProfileController::class, 'updateSignature'])->name('signature.update');
    });
});
