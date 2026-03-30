<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\{
    HomeController,
    AdminController,
    UserController,

    AgentController,
    CourrierController,
    DirectionController,
    ServiceController,
    PresenceController,
    AbsenceController,
    TypeAbsenceController,
    AnnonceController,
    AgentServiceController,
    ImputationController,
    StatistiqueController,
    ReponseController,
    PostController,
    RoleController,
    ExtractionController,
    HolidayController,
    RapportController,
    AuditLogController,
    InterimController
};

use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\ScriptExtraction;


// Dans routes/web.php

Route::middleware(['auth'])->group(
    function () {
        // C'est ici que l'utilisateur arrive juste après s'être connecté
        Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| 1. ACCÈS PUBLICS & AUTHENTIFICATION DE BASE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome-login');
})->middleware('guest');

Auth::routes();



Route::middleware(['auth'])->group(function () {

    // 1. ROUTE POUR L'ADMIN (Celle qui utilise votre SELECT d'agents)
    // C'est celle-ci que votre formulaire Blade actuel doit utiliser
    Route::post('/absences/admin-store', [AbsenceController::class, 'store'])->name('absences.store');

    // 2. ROUTE POUR L'AGENT (Auto-demande)
    // Elle reste pour les agents qui font leur propre demande sans choisir
    Route::post('/absences/ma-demande', [AbsenceController::class, 'storeAutorisationAbsence'])->name('absences.storeAutorisation');

    // --- Le reste de vos routes ---
    Route::get('/mes-absences', [AbsenceController::class, 'indexAutorisation'])->name('absences.indexAutorisation');
    Route::get('/absences/imprimer/{absence}', [AbsenceController::class, 'print'])->name('absences.print');
    Route::get('/chef/validations', [AbsenceController::class, 'indexChef'])->name('chef.absences.index');
    Route::post('/chef/valider/{absence}', [AbsenceController::class, 'valider'])->name('chef.absences.valider');
    Route::post('/absences/rejeter/{id}', [AbsenceController::class, 'rejeter'])->name('chef.absences.rejeter');
});



Route::resource('holidays', HolidayController::class);

Route::get('/absences/admin/create', [AbsenceController::class, 'createListe'])->name('absences.createListe');
// Ajoutez cette route spécifique AVANT ou APRÈS vos ressources existantes
Route::post('/absences/store-grouped', [AbsenceController::class, 'storeGrouped'])->name('absences.storeGrouped');

// Route pour la vue mensuelle
Route::get('/rapport-mensuel', [RapportController::class, 'mensuel'])->name('rapports.mensuel');

// Route pour l'export PDF
Route::get('/rapports/export-pdf/{agent_id}/{periode}', [RapportController::class, 'exportPDF'])->name('rapports.export.pdf');

Route::get('/administration/journal-logs', [AuditLogController::class, 'journalLogs'])
    ->name('admin.logs')
    ->middleware(['auth', 'role:admin|Superviseur']); // Sécurisez l'accès

// Route pour la suppression individuelle
Route::delete('/admin/logs/{id}', [AuditLogController::class, 'destroy'])->name('admin.logs.destroy');

// Route pour la suppression individuelle (AJAX)
Route::delete('/admin/logs/{id}/ajax', [AuditLogController::class, 'destroy'])->name('admin.logs.destroy.ajax');
// Route pour vider tout le journal
Route::delete('/admin/logs-clear', [App\Http\Controllers\AuditLogController::class, 'clearAll'])->name('admin.logs.clear');

Route::get('/admin/logs', [AuditLogController::class, 'journalLogs'])->name('admin.logs.index');




Route::middleware(['auth'])->group(function () {
    Route::post('/interims/store', [InterimController::class, 'store'])->name('interims.store');
});



// Vérifiez que le nom 'interims.store' est bien défini
Route::post('/interims', [InterimController::class, 'store'])->name('interims.store');

// Dans routes/web.php
Route::post('/interims/store', [App\Http\Controllers\InterimController::class, 'store'])->name('interims.store');
Route::post('/imputations/check-interim', [ImputationController::class, 'checkInterim'])->name('imputations.check-interim');


/*
|--------------------------------------------------------------------------
| 2. ESPACE SÉCURISÉ (Authentification requise)
|--------------------------------------------------------------------------
*/




Route::middleware(['auth'])->group(function () {

    // --- ROUTES POUR LA GESTION DES INTÉRIMS ---

    // 1. Liste de tous les intérims
    Route::get('/interims', [InterimController::class, 'index'])->name('interims.index');

    // 2. Formulaire de création d'un nouvel intérim
    Route::get('/interims/create', [InterimController::class, 'create'])->name('interims.create');

    // 3. Enregistrement d'un nouvel intérim (crée aussi l'absence)
    Route::post('/interims', [InterimController::class, 'store'])->name('interims.store');

    // 4. Affichage des détails d'un intérim spécifique
    Route::get('/interims/{id}', [InterimController::class, 'show'])->name('interims.show');

    // 5. Formulaire de modification d'un intérim existant
    Route::get('/interims/{id}/edit', [InterimController::class, 'edit'])->name('interims.edit');

    // 6. Mise à jour de l'intérim (met à jour aussi l'absence liée)
    Route::put('/interims/{id}', [InterimController::class, 'update'])->name('interims.update');

    // 7. Arrêt prématuré d'un intérim (désactive sans supprimer)
    Route::patch('/interims/{interim}/stop', [InterimController::class, 'stop'])->name('interims.stop');

    // 8. Suppression définitive (supprime aussi l'absence liée)
    Route::delete('/interims/{id}', [InterimController::class, 'destroy'])->name('interims.destroy');
});

Route::middleware(['auth'])->group(function () {



    // 1. Affichage de l'interface de saisie
    Route::get('/extraction', [ExtractionController::class, 'index'])
        ->name('extraction.index');

    // 2. Traitement du script SQL/Oracle (POST)
    Route::post('/extraction/execute', [ExtractionController::class, 'execute'])
        ->name('extraction.execute');

    // 3. Exportation des résultats vers Excel (POST)
    Route::post('/extraction/export', [ExtractionController::class, 'export'])
        ->name('extraction.export');
});
Route::get('/extraction/execute', function () {
    return redirect()->route('extraction.index');
});

// Route pour charger les données d'un script en JSON au clic
Route::get('/extraction/scripts/{id}', function ($id) {
    return \App\Models\ScriptExtraction::findOrFail($id);
})->name('scripts.json');

// Cette route permet au JS de récupérer les données du script
Route::get('/extraction/scripts/{id}', function ($id) {
    return ScriptExtraction::findOrFail($id);
});
Route::delete('/extraction/scripts/{id}', [ExtractionController::class, 'destroy'])->name('scripts.destroy');


Route::middleware(['auth'])->group(function () {



    // --- ADMINISTRATION SYSTÈME & RÔLES ---
    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('/admin/coffre-fort', [AdminController::class, 'coffreFort'])->name('admin.coffre-fort');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');

        // Gestion des Rôles (Spatie)
        Route::resource('roles', RoleController::class);
    });

    Route::middleware(['can:voir-utilisateurs'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/upgrade', [UserController::class, 'upgradeUser'])->name('users.upgrade');
    });

    Route::middleware(['can:access-admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // --- GESTION DES ABSENCES (LOGIQUE DE RÔLES) ---
    // Espace Agent (Tout utilisateur)

    Route::post('/absences/check-overlap', [AbsenceController::class, 'checkOverlap'])->name('absences.checkOverlap');
    Route::get('/absences/pdf/{id}', [AbsenceController::class, 'genererPdf'])->name('absences.genererPdf');


    Route::get('/mon-autorisation-absence', [AbsenceController::class, 'monautorisation'])->name('absences.monautorisation');
    Route::post('/absences/monstore', [AbsenceController::class, 'monstore'])->name('absences.monstore');

    // Espace Contrôle (Admin, RH, Superviseur) - Notez la majuscule sur Superviseur
    Route::middleware(['role:admin|rh|Superviseur'])->group(function () {
        Route::get('/absences/validations', [AbsenceController::class, 'validationListe'])->name('absences.validation_liste');
        Route::post('/absences/approuver/{id}', [AbsenceController::class, 'approuver'])->name('absences.approuver');
        Route::resource('typeabsences', TypeAbsenceController::class); // Ajouté pour la cohérence
    });



    /*
    |--------------------------------------------------------------------------
    | 3. ESPACE MÉTIER (Authentification + Changement de mot de passe forcé)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['force.password'])->group(function () {

        // --- DASHBOARDS & PROFIL ---
        Route::get('/tableau-de-bord', [AgentController::class, 'dashb'])->name('agent.dashboard');




        // --- GESTION DES STRUCTURES ---
        Route::resource('directions', DirectionController::class);
        Route::resource('services', ServiceController::class);
        Route::get('/directions/{direction}/services', [DirectionController::class, 'getServices'])->name('directions.services');

        // --- GESTION DES AGENTS ---
        Route::prefix('agents')->name('agents.')->group(function () {
            Route::get('/nouveau', [AgentController::class, 'nouveau'])->name('nouveau');
            Route::post('/enregistrer', [AgentController::class, 'Enr'])->name('enregistrer');
            Route::match(['get', 'post'], '/par-service', [AgentServiceController::class, 'listeParService'])->name('par.service');
            Route::match(['get', 'post'], '/par-service/recherche', [AgentServiceController::class, 'recherche'])->name('par.service.recherche');
        });

        // Si vous utilisez une route ressource (recommandé)
        Route::resource('agents', AgentController::class);

        // OU si vous déclarez manuellement
        Route::get('/agents/create', [AgentController::class, 'create'])->name('agents.create');
        Route::post('/agents', [AgentController::class, 'store'])->name('agents.store');
        Route::get('/agents/{agent}/edit', [AgentController::class, 'edit'])->name('agents.edit');
        Route::put('/agents/{agent}', [AgentController::class, 'update'])->name('agents.update');
        Route::delete('/agents/{agent}', [AgentController::class, 'destroy'])->name('agents.destroy');

        // Note : Si vous utilisez Route::resource, les routes ci-dessus sont générées automatiquement

        Route::resource('agents', AgentController::class)->except(['create', 'store']);
        Route::resource('agents', AgentController::class);


        // --- PRÉSENCES & POINTAGES ---

        Route::prefix('presences')->name('presences.')->group(function () {
            Route::get('/mon-pointage', [PresenceController::class, 'monPointage'])->name('monPointage');
            Route::post('/mon-pointage/enregistrer', [PresenceController::class, 'enregistrerPointage'])->name('enregistrerPointage');
            Route::get('/mon-historique', [PresenceController::class, 'monHistorique'])->name('monHistorique');
            Route::get('/liste-filtree', [PresenceController::class, 'listeFiltree'])->name('listeFiltree');
        });






        // --- GESTION DES COURRIERS & AFFECTATIONS ---
        Route::prefix('courriers')->name('courriers.')->group(function () {
            Route::get('/visualiser/{id}', [CourrierController::class, 'visualiserDocument'])->name('visualiser');
            Route::get('/recherche', [CourrierController::class, 'RechercheAffichage'])->name('RechercheAffichage');
            Route::get('/recherche/resultats', [CourrierController::class, 'Recherche'])->name('Recherche');
            Route::get('/archives', [CourrierController::class, 'archives'])->name('archives');
            Route::post('/{courrier}/unlock', [CourrierController::class, 'unlock'])->name('unlock');
        });

        // Route pour signer un courrier spécifique
        Route::post('/courriers/{id}/sign', [CourrierController::class, 'signCourrier'])->name('courriers.sign');

        // Route pour l'envoi du mail
        Route::post('/courriers/{id}/send-mail', [CourrierController::class, 'sendMail'])->name('courriers.send-mail');

        Route::resource('courriers', CourrierController::class);

        // --- RESSOURCES HUMAINES (Présences & Absences) ---
        Route::prefix('presences')->name('presences.')->group(function () {
            // Interfaces de Contrôle & Validation
            Route::get('/validation-hebdo', [PresenceController::class, 'indexValidationHebdo'])->name('validation-hebdo');
            Route::post('/valider-hebdo', [PresenceController::class, 'storeValidationHebdo'])->name('valider-hebdo');
            Route::get('/etat', [PresenceController::class, 'statsPresences'])->name('etat');
            Route::get('/stats', [PresenceController::class, 'stats'])->name('etatperiodique');

            // Interfaces Agent
            Route::get('/mon-pointage', [PresenceController::class, 'monPointage'])->name('monPointage');
            Route::post('/mon-pointage/enregistrer', [PresenceController::class, 'enregistrerPointage'])->name('enregistrerPointage');
            Route::get('/mon-historique', [PresenceController::class, 'monHistorique'])->name('monHistorique');
            Route::get('/liste-filtree', [PresenceController::class, 'listeFiltree'])->name('listeFiltree');
        });

        // Rapports & Ressources (Hors préfixe pour correspondre à vos noms de routes existants)
        Route::get('/rapports/presences/periodique', [PresenceController::class, 'rapport'])->name('rapports.presences.periodique');

        Route::resource('presences', PresenceController::class);
        Route::resource('absences', AbsenceController::class);
        Route::resource('typeabsences', TypeAbsenceController::class);

        // --- GESTION DES AGENTS (Rappel) ---
        Route::prefix('agents')->name('agents.')->group(function () {
            Route::get('/nouveau', [AgentController::class, 'nouveau'])->name('nouveau');
            Route::post('/enregistrer', [AgentController::class, 'Enr'])->name('enregistrer');
            Route::match(['get', 'post'], '/par-service', [AgentServiceController::class, 'listeParService'])->name('par.service');
        });
        Route::resource('agents', AgentController::class)->except(['create', 'store']);

        // --- GESTION DES IMPUTATIONS & RÉPONSES ---
        Route::prefix('imputations')->name('imputations.')->group(function () {
            Route::get('/mes-imputations', [ImputationController::class, 'mesImputations'])->name('mes_imputations');
        });
        Route::resource('imputations', ImputationController::class);
        Route::post('/reponses/store', [ReponseController::class, 'store'])->name('reponses.store');
        // Ajoutez cette ligne dans votre fichier de routes
        Route::post('/reponses/{id}/valider', [ReponseController::class, 'valider'])->name('reponses.valider');

        // --- TACHES & ANNONCES ---
        Route::resource('annonces', AnnonceController::class);

        // --- STATISTIQUES ---
        Route::prefix('statistiques')->name('statistiques.')->group(function () {
            Route::get('/', [StatistiqueController::class, 'index'])->name('index');
            Route::get('/dashboard', [StatistiqueController::class, 'dashboard'])->name('dashboard');
        });

        // --- GESTION DES POSTS ---
        Route::delete('/post/{id}', [PostController::class, 'destroy'])->middleware('can:supprimer-articles');
    }); // Fin middleware force.password
}); // Fin middleware auth
