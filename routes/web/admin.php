<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    UserController,
    RoleController,
    AuditLogController,
    ExtractionController,
    StatistiqueController
};
use App\Models\ScriptExtraction;

/*

|--------------------------------------------------------------------------
| ROUTES D'ADMINISTRATION
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- 1. DASHBOARD & ACCÈS GÉNÉRAL ---
    Route::middleware(['can:access-admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // --- 2. GESTION DES UTILISATEURS & RÔLES ---
    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/admin/coffre-fort', [AdminController::class, 'coffreFort'])->name('admin.coffre-fort');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');

        // Ressources Spatie
        Route::resource('roles', RoleController::class);
    });

    Route::middleware(['can:voir-utilisateurs'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/upgrade', [UserController::class, 'upgradeUser'])->name('users.upgrade');
    });

    // --- 3. JOURNAL D'AUDIT (LOGS) ---
    Route::middleware(['role:admin|Superviseur'])->prefix('admin/logs')->name('admin.logs.')->group(function () {
        Route::get('/', [AuditLogController::class, 'journalLogs'])->name('index');
        Route::delete('/clear', [AuditLogController::class, 'clearAll'])->name('clear');
        Route::delete('/{id}', [AuditLogController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/ajax', [AuditLogController::class, 'destroy'])->name('destroy.ajax');
    });

    // --- 4. EXTRACTION DE DONNÉES ---
    Route::prefix('extraction')->name('extraction.')->group(function () {
        Route::get('/', [ExtractionController::class, 'index'])->name('index');
        Route::post('/execute', [ExtractionController::class, 'execute'])->name('execute');
        Route::get('/execute', fn() => redirect()->route('extraction.index')); // Redirection si accès en GET
        Route::post('/export', [ExtractionController::class, 'export'])->name('export');
    });
        // GESTION DES SCRIPTS (Hors préfixe 'extraction' pour correspondre à votre vue)
        Route::name('scripts.')->group(function () {
            Route::get('/extraction/scripts/{id}', fn($id) => ScriptExtraction::findOrFail($id))->name('json');
            Route::delete('/extraction/scripts/{id}', [ExtractionController::class, 'destroy'])->name('destroy');
        });

        // --- 5. STATISTIQUES ---
    Route::prefix('statistiques')->name('statistiques.')->group(function () {
        Route::get('/', [StatistiqueController::class, 'index'])->name('index');
        Route::get('/dashboard', [StatistiqueController::class, 'dashboard'])->name('dashboard');
    });

});
