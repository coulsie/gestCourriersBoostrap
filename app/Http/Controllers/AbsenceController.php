<?php
namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Agent;
use App\Models\TypeAbsence;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class AbsenceController extends Controller
{
    /**
     * Affiche la liste des ressources (absences).
     */
    public function index(): View
    {
        // Récupère toutes les absences et charge les relations Agent et TypeAbsence
        $absences = Absence::with(['agent', 'typeAbsence'])->latest()->paginate();

        // Renvoie les données à une vue Blade (par ex. resources/views/absences/index.blade.php)
        return view('Absences.index', compact('absences'));
    }


    public function indexAutorisation()
    {
        $absences = Auth::user()->agent->absences()
            ->with('typeAbsence') // <--- AJOUTEZ CECI
            ->orderBy('created_at', 'desc')
            ->get();

        return view('absences.agentAutorisation', compact('absences'));
    }



    public function indexChef()
    {
        $agent = auth::user()->agent;

        // 1. Liste des statuts autorisés à valider
        $rolesResponsables = [
            'Chef de service',
            'Sous-directeur',
            'Directeur',
            'Conseiller Technique',
            'Conseiller Spécial'
        ];

        // 2. Vérification si l'agent connecté a l'un de ces statuts
        if (!in_array($agent->status, $rolesResponsables)) {
            return back()->with('error', "Accès refusé : votre statut actuel (" . $agent->status . ") ne vous permet pas de valider des absences.");
        }

        // 3. Récupérer les absences des agents du MÊME service
        // (Exclure l'agent connecté lui-même pour qu'il ne valide pas sa propre demande)
        $demandes = \App\Models\Absence::whereHas('agent', function ($query) use ($agent) {
            $query->where('service_id', $agent->service_id)
                ->where('id', '!=', $agent->id);
        })
            ->where('statut_autorisation_absence', 'en_attente')
            ->with('agent')
            ->get();

        return view('Absences.chef_validation', compact('demandes'));
    }


    public function valider(Request $request, $id)
    {
        $responsable = auth::user()->agent;
        $absence = \App\Models\Absence::findOrFail($id);

        $rolesResponsables = ['Chef de service', 'Sous-directeur', 'Directeur', 'Conseiller Technique', 'Conseiller Spécial'];

        // Sécurité : Statut autorisé ET même service
        if (!in_array($responsable->status, $rolesResponsables) || $absence->agent->service_id !== $responsable->service_id) {
            abort(403, "Vous n'avez pas les droits pour valider cette demande.");
        }

        $absence->update([
            'statut_autorisation_absence' => 'valide_chef',
            'approuvee' => 2,
            'comment_absence_chef' => $request->commentaire,
        ]);



        return redirect()->back()->with('success', "Demande validée par le " . $responsable->status);
    }


    public function rejeter(Request $request, $id)
    {
        $absence = \App\Models\Absence::findOrFail($id);

        $absence->update([
            'statut_autorisation_absence' => 'rejete',
            'approuvee' => 0, // Ou une autre valeur signifiant "Refusé" selon votre logique
            'comment_absence_chef' => $request->commentaire ?? 'Demande rejetée par le responsable.'
        ]);

        return redirect()->back()->with('success', "La demande de {$absence->agent->first_name} a été rejetée.");
    }


    public function print(Absence $absence)
    {
        // On charge les relations nécessaires pour éviter les erreurs dans la vue
        $absence->load(['agent.service.chef.user', 'typeAbsence']);

        // Vérification de sécurité
        if ($absence->statut_autorisation_absence !== 'valide_chef') {
            return back()->with('error', "Cette demande n'est pas encore validée.");
        }

        $pdf = Pdf::loadView('absences.pdf', compact('absence'));

        return $pdf->stream('Autorisation_Absence_' . $absence->agent->matricule . '.pdf');
    }


    public function create()
    {
        // 1. Récupérer tous les agents pour la liste déroulante
        $agents = Agent::all();

        // 2. Récupérer tous les types d'absences (C'EST ICI QUE MANQUAIT LA VARIABLE)
        $typeAbsences = TypeAbsence::all();

        // 3. Envoyer les deux variables à la vue
        return view('Absences.create', compact('agents', 'typeAbsences'));
    }

    /**
     * Stocke une nouvelle ressource dans la base de données.
     */
    public function store(Request $request)
    {
        // 1. Validation : On récupère les données nettoyées dans $validated
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type_absence_id' => 'required|exists:type_absences,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'document_justificatif' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:8192',
        ]);

        // 2. Vérification du chevauchement (On utilise $validated['agent_id'])
        $conflit = \App\Models\Absence::where('agent_id', $validated['agent_id'])
            ->where(function ($query) use ($validated) {
                $query->where('date_debut', '<=', $validated['date_fin'])
                    ->where('date_fin', '>=', $validated['date_debut']);
            })->first();

        if ($conflit) {
            $agent = \App\Models\Agent::findOrFail($validated['agent_id']);
            $msg = "Erreur : {$agent->last_name} a déjà une absence du " .
                \Carbon\Carbon::parse($conflit->date_debut)->format('d/m/Y') .
                " au " . \Carbon\Carbon::parse($conflit->date_fin)->format('d/m/Y') . ".";

            return redirect()->back()->withInput()->with('error', $msg);
        }

        // 3. Préparation des statuts (Logique : 0=Attente, 1=Rejeté, 2=Approuvé)
        if ($request->has('approuvee')) {
            // Si l'admin coche la case "Approuver immédiatement"
            $validated['approuvee'] = 2;
            $validated['statut_autorisation_absence'] = 'valide_chef';
        } else {
            // PAR DÉFAUT : L'absence est créée "En attente" pour le chef
            $validated['approuvee'] = 0;
            $validated['statut_autorisation_absence'] = 'en_attente';
        }

        // Initialiser le commentaire du chef à vide à la création
        $validated['comment_absence_chef'] = null;


        // 4. Gestion du fichier
        if ($request->hasFile('document_justificatif')) {
            $file = $request->file('document_justificatif');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('JustificatifAbsences'), $fileName);
            $validated['document_justificatif'] = $fileName;
        }

        // 5. CRÉATION : On utilise uniquement le tableau $validated
        // Cela empêche toute interférence avec auth()->id()
        $absence = \App\Models\Absence::create($validated);

        return redirect()->route('absences.index')->with([
            'success' => 'L\'absence a été enregistrée avec succès pour l\'agent sélectionné !',
        ]);
    }




    /**
     * Met à jour la ressource spécifiée dans la base de données.
     */


    public function storeAutorisationAbsence(Request $request)
    {
        // 1. Validation : On utilise le nom EXACT du champ de votre formulaire
        $request->validate([
            'type_absence_id' => 'required|exists:type_absences,id',
            'date_debut'      => 'required|date|after_or_equal:today',
            'date_fin'        => 'required|date|after_or_equal:date_debut',
        ]);

        $agent = auth::user()->agent;

        // 2. Création : On utilise la valeur validée
        \App\Models\Absence::create([
            'agent_id'                    => $agent->id,
            'type_absence_id'             => $request->type_absence_id, // <--- C'est ici que c'était NULL
            'date_debut'                  => $request->date_debut,
            'date_fin'                    => $request->date_fin,
            'approuvee'                   => 0,
            'statut_autorisation_absence' => 'en_attente',
        ]);

        return redirect()->route('absences.indexAutorisation')
            ->with('success', 'Votre demande a été envoyée avec succès.');
    }





    public function update(Request $request, Absence $absence): RedirectResponse
{
    // 1. Validation rigoureuse
    $validatedData = $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'type_absence_id' => 'required|exists:type_absences,id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'approuvee' => 'nullable', // Changé en nullable pour gérer la checkbox manuellement
        'document_justificatif' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'notes' => 'nullable|string',
    ]);

    // Force la valeur booléenne pour la checkbox
    $validatedData['approuvee'] = $request->has('approuvee') ? 1 : 0;

    // 2. Gestion du document scanné (Logique identique au Store)
    if ($request->hasFile('document_justificatif')) {

        // --- ÉTAPE A : Supprimer l'ancien fichier s'il existe ---
        if ($absence->document_justificatif && file_exists(public_path('JustificatifAbsences/' . $absence->document_justificatif))) {
            unlink(public_path('JustificatifAbsences/' . $absence->document_justificatif));
        }

        // --- ÉTAPE B : Stocker le nouveau fichier ---
        $file = $request->file('document_justificatif');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Déplacement physique dans public/JustificatifAbsences
        $file->move(public_path('JustificatifAbsences'), $fileName);

        // Enregistrer le nom du fichier pour la base de données
        $validatedData['document_justificatif'] = $fileName;

        // Mise à jour automatique du statut
        $validatedData['statut'] = 'Justifiée';
    }

    // 3. Mise à jour de l'instance
    $absence->update($validatedData);

    // 4. Redirection
    return redirect()->route('absences.index')
        ->with('success', 'L\'absence de l\'agent a été mise à jour avec succès.');
}
    /**
     * Supprime la ressource spécifiée de la base de données.
     */
    public function destroy(Absence $absence): RedirectResponse
    {
        $absence->delete();

        return redirect()->route('absences.index')->with('success', 'Absence supprimée.');
    }

    public function show($id)
    {
        // Charge l'absence et la relation 'typeAbsence' associée.
        // Si l'absence n'existe pas, Laravel générera automatiquement une 404.
        $absence = Absence::with('typeAbsence', 'agent')->findOrFail($id);

        // Passe l'objet $absence complet (avec ses relations chargées) à la vue.
        return view('Absences.show', compact('absence'));
    }


    public function edit(absence $absence): View
    {
        $type_absences = TypeAbsence::all();
        $agents = Agent::all();

        return view('Absences.edit', compact('absence', 'type_absences', 'agents'));
    }




public function monautorisation()
{
    // 1. Récupérer les types d'absences pour le formulaire
    $typeAbsences = \App\Models\TypeAbsence::all();

    // Gestion du cas vide pour les types
    if ($typeAbsences->isEmpty()) {
        $typeAbsences = collect([(object)['id' => 0, 'nom_type' => 'Aucun motif trouvé']]);
    }

    // 2. Récupérer l'agent connecté
    $agent = auth::user()->agent;

    // 3. Récupérer l'historique des absences de cet agent (indispensable pour la ligne 111 de votre vue)
    $absences = \App\Models\Absence::with('type')
                ->where('agent_id', $agent->id)
                ->latest()
                ->paginate(5); // On en affiche 5 par page sous le formulaire

    return view('Absences.monautorisation', compact('typeAbsences', 'absences'));
}


public function validationListe()
{
    // On charge les absences avec leurs relations
    $absences = \App\Models\Absence::with(['type', 'agent'])
                ->where('approuvee', 0)
                ->latest()
                ->paginate(15); // paginate() exécute déjà la requête, ne pas ajouter get()

    return view('Absences.validation', compact('absences'));
}




public function approuver(Request $request, $id)
{
    $absence = \App\Models\Absence::findOrFail($id);
    // 1 pour Approuvé, 2 pour Rejeté (selon votre logique)
    $absence->update(['approuvee' => $request->status]);

    return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
}


public function monstore(Request $request)
{
    // 1. Validation (Date de fin >= Date de début)
    $validatedData = $request->validate([
        'type_absence_id' => 'required|exists:type_absences,id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'document_justificatif' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:8192',
    ]);

    // 2. Récupération de l'agent
    $agent = auth::user()->agent;
    if (!$agent) {
        return redirect()->back()->with('error', 'Profil agent introuvable.');
    }

    // --- NOUVEAU : VÉRIFICATION DU CHEVAUCHEMENT ---
    $debut = $request->date_debut;
    $fin = $request->date_fin;

    $conflit = \App\Models\Absence::where('agent_id', $agent->id)
        ->where(function ($query) use ($debut, $fin) {
            $query->where(function ($q) use ($debut, $fin) {
                $q->where('date_debut', '<=', $fin)
                  ->where('date_fin', '>=', $debut);
            });
        })
        ->first();

    if ($conflit) {
        $msg = "Erreur : Vous avez déjà une absence enregistrée du " .
               \Carbon\Carbon::parse($conflit->date_debut)->format('d/m/Y') .
               " au " . \Carbon\Carbon::parse($conflit->date_fin)->format('d/m/Y') . ".";

        return redirect()->back()->withInput()->with('error', $msg);
    }
    // -----------------------------------------------

    // 3. Préparation des données
    $validatedData['agent_id'] = $agent->id;
    $validatedData['approuvee'] = 0;

    // 4. Gestion du fichier
    if ($request->hasFile('document_justificatif')) {
        $file = $request->file('document_justificatif');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('JustificatifAbsences'), $fileName);
        $validatedData['document_justificatif'] = $fileName;
    }

       // 5. Création
    $absence = \App\Models\Absence::create($validatedData);

        // On prépare le message de succès et l'URL de téléchargement du PDF
        // Ajoutez le "->" avant le "with"
        return redirect()->route('absences.indexAutorisation')->with([
            'success' => 'Votre demande d\'absence a été enregistrée avec succès ! ',
            // 'pdf_url' => route('absences.genererPdf', $absence->id)
        ]);
    }



    public function checkOverlap(Request $request) {
        $agentId = auth::user()->agent->id;
        $conflit = \App\Models\Absence::where('agent_id', $agentId)
            ->where(function ($q) use ($request) {
                $q->where('date_debut', '<=', $request->date_fin)
                ->where('date_fin', '>=', $request->date_debut);
            })->first();

        if ($conflit) {

            return response()->json([
                'conflict' => true,
                'message' => "Vous avez déjà une absence du " .
                            \Carbon\Carbon::parse($conflit->date_debut)->format('d/m/Y') . " au " .
                            \Carbon\Carbon::parse($conflit->date_fin)->format('d/m/Y') .
                            ". Veuillez reconsidérer les dates."
            ]);


        }

        return response()->json(['conflict' => false]);
    }



public function genererPdf($id)
{
    $absence = Absence::with(['agent', 'type'])->findOrFail($id);
    $agent = $absence->agent;

    $pdf = Pdf::loadView('Absences.pdf_autorisation', compact('absence', 'agent'));


    // Pour télécharger le fichier :
    return $pdf->download('autorisation_absence_'.$agent->last_name.'.pdf');
}


public function createListe()
{
    // Tri par nom puis prénom pour faciliter la recherche visuelle
    $agents = \App\Models\Agent::orderBy('last_name', 'asc')
                               ->orderBy('first_name', 'asc')
                               ->get();

    $typeAbsences = \App\Models\TypeAbsence::orderBy('nom_type')->get();

    // Assurez-vous que le nom du fichier correspond (create_admin.blade.php)
    return view('absences.create_admin', compact('agents', 'typeAbsences'));
}


public function storeGrouped(Request $request)
{
    $request->validate([
        'agent_ids' => 'required|array|min:1',
        'type_absence_id' => 'required|exists:type_absences,id',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'document_justificatif' => 'nullable|file|mimes:pdf,jpg,png,docx|max:8192',
    ]);

    // 1. PHASE DE VÉRIFICATION GLOBALE (Avant toute création)
    $conflits = [];
    foreach ($request->agent_ids as $id) {
        $check = \App\Models\Absence::where('agent_id', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('date_debut', '<=', $request->date_debut)
                            ->where('date_fin', '>=', $request->date_fin);
                      });
            })->first();

        if ($check) {
            $agent = \App\Models\Agent::find($id);
            $conflits[] = "<strong>{$agent->last_name} {$agent->first_name}</strong> est déjà autorisé du " .
                          \Carbon\Carbon::parse($check->date_debut)->format('d/m/Y') . " au " .
                          \Carbon\Carbon::parse($check->date_fin)->format('d/m/Y');
        }
    }

    // 2. SI CONFLIT : On arrête tout et on renvoie l'erreur


        if (count($conflits) > 0) {
        $message = '<div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle fa-lg me-2 text-danger"></i>
                        <strong class="text-danger">Action Interrompue !</strong>
                    </div>
                    <p class="small mb-2 border-bottom pb-1">Les agents suivants sont déjà autorisés sur cette période :</p>
                    <ul class="list-group list-group-flush rounded-3 mb-2 shadow-sm" style="font-size: 0.85rem;">';

        foreach ($conflits as $conflit) {
            $message .= '<li class="list-group-item list-group-item-danger py-1 px-2">
                            <i class="fas fa-user-clock me-1"></i> ' . $conflit . '
                        </li>';
        }

        $message .= '</ul>
                    <p class="mb-0 small text-muted italic"><i class="fas fa-info-circle me-1"></i> Retirez ces agents ou modifiez les dates.</p>';


        return back()->withInput()->with('conflit_absence', $message);
    }




    // 3. PHASE DE CRÉATION (Seulement si 0 conflit)
    return \DB::transaction(function () use ($request) {
        $fileName = null;
        if ($request->hasFile('document_justificatif')) {
            $file = $request->file('document_justificatif');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('JustificatifAbsences'), $fileName);
        }

        foreach ($request->agent_ids as $id) {
            \App\Models\Absence::create([
                'agent_id' => $id,
                'type_absence_id' => $request->type_absence_id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'motif' => $request->motif,
                'document_justificatif' => $fileName,
                'approuvee' => 0, // En attente d'approbation
            ]);
        }

        return redirect()->route('absences.index')
            ->with('success', count($request->agent_ids) . " demandes d'absences groupées créées avec succès (En attente).");
    });
}


}
