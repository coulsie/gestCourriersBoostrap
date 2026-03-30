<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\{
    UserController,
    AdminController,
    AbsenceController,
    TypeAbsenceController,
    ProfileController,
    AgentController,
    DirectionController,
    ServiceController,
    AgentServiceController,
    PresenceController,
    CourrierController,
    HolidayController,
    RapportController,
    AuditLogController,
    InterimController,
    ExtractionController,
    Auth\ForgotPasswordController,
    ImputationController
};
use App\Models\ScriptExtraction;

/*

|--------------------------------------------------------------------------
| 1. ACCÈS PUBLICS & AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome-login');
})->middleware('guest');

Auth::routes();

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('forgot-password', 'showLinkRequestForm')->name('password.request');
    Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
});

/*

|--------------------------------------------------------------------------
| 2. ESPACE SÉCURISÉ (Commun à tous les utilisateurs connectés)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- Profil & Sécurité ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/signature', [ProfileController::class, 'editSignature'])->name('signature.edit');
        Route::post('/signature', [ProfileController::class, 'updateSignature'])->name('signature.update');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('password.custom.update');
    });

    // --- Absences (Fonctions de base Agent) ---
    Route::prefix('absences')->name('absences.')->group(function () {
        Route::get('/mes-absences', [AbsenceController::class, 'indexAutorisation'])->name('indexAutorisation');
        Route::get('/mon-autorisation', [AbsenceController::class, 'monautorisation'])->name('monautorisation');
        Route::post('/mon-store', [AbsenceController::class, 'monstore'])->name('monstore');
        Route::post('/check-overlap', [AbsenceController::class, 'checkOverlap'])->name('checkOverlap');
        Route::get('/pdf/{id}', [AbsenceController::class, 'genererPdf'])->name('genererPdf');
        Route::get('/imprimer/{absence}', [AbsenceController::class, 'print'])->name('print');
    });

    // --- Intérims & Imputations ---
    Route::resource('interims', InterimController::class);
    Route::patch('/interims/{interim}/stop', [InterimController::class, 'stop'])->name('interims.stop');
    Route::post('/imputations/check-interim', [ImputationController::class, 'checkInterim'])->name('imputations.check-interim');
});

/*

|--------------------------------------------------------------------------
| 3. ADMINISTRATION & CONTRÔLE (Rôles spécifiques)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- Superviseurs & RH (Validation des Absences) ---
    Route::middleware(['role:admin|rh|Superviseur'])->group(function () {
        Route::prefix('absences')->name('absences.')->group(function () {
            Route::get('/validations', [AbsenceController::class, 'validationListe'])->name('validation_liste');
            Route::post('/approuver/{id}', [AbsenceController::class, 'approuver'])->name('approuver');
            Route::post('/admin-store', [AbsenceController::class, 'store'])->name('store');
            Route::get('/admin/create', [AbsenceController::class, 'createListe'])->name('createListe');
            Route::post('/store-grouped', [AbsenceController::class, 'storeGrouped'])->name('storeGrouped');
        });
        Route::resource('typeabsences', TypeAbsenceController::class);
    });

    // --- Administration Système (Logs & Users) ---
    Route::middleware(['role:admin|Superviseur'])->group(function () {
        Route::resource('users', UserController::class)->middleware('can:voir-utilisateurs');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('can:access-admin');

        Route::prefix('admin/logs')->name('admin.logs.')->group(function () {
            Route::get('/', [AuditLogController::class, 'journalLogs'])->name('index');
            Route::delete('/clear', [AuditLogController::class, 'clearAll'])->name('clear');
            Route::delete('/{id}', [AuditLogController::class, 'destroy'])->name('destroy');
        });
    });
});

/*

|--------------------------------------------------------------------------
| 4. ESPACE MÉTIER (Pointage, Agents, Courriers - Force Password)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'force.password'])->group(function () {

    Route::get('/tableau-de-bord', [AgentController::class, 'dashb'])->name('agent.dashboard');

    // --- Gestion des Agents & Structures ---
    Route::resource('directions', DirectionController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('agents', AgentController::class);
    Route::get('/directions/{direction}/services', [DirectionController::class, 'getServices'])->name('directions.services');

    // --- Présences & Rapports ---
    Route::prefix('presences')->name('presences.')->group(function () {
        Route::get('/mon-pointage', [PresenceController::class, 'monPointage'])->name('monPointage');
        Route::post('/mon-pointage/enregistrer', [PresenceController::class, 'enregistrerPointage'])->name('enregistrerPointage');
        Route::get('/mon-historique', [PresenceController::class, 'monHistorique'])->name('monHistorique');
        Route::get('/etat', [PresenceController::class, 'statsPresences'])->name('etat');
        Route::get('/validation-hebdo', [PresenceController::class, 'indexValidationHebdo'])->name('validation-hebdo');
    });

    // --- Courriers ---
    Route::prefix('courriers')->name('courriers.')->group(function () {
        Route::get('/recherche', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
        Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
        Route::post('/{id}/sign', [CourrierController::class, 'signCourrier'])->name('sign');
        Route::post('/{id}/send-mail', [CourrierController::class, 'sendMail'])->name('send-mail');
    });
    Route::resource('courriers', CourrierController::class);

    // --- Extraction ---
    Route::prefix('extraction')->name('extraction.')->group(function () {
        Route::get('/', [ExtractionController::class, 'index'])->name('index');
        Route::post('/execute', [ExtractionController::class, 'execute'])->name('execute');
        Route::get('/scripts/{id}', function ($id) {
            return ScriptExtraction::findOrFail($id);
        })->name('scripts.json');
    });
});
