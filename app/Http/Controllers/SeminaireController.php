<?php

namespace App\Http\Controllers;

use App\Models\Seminaire;
use App\Models\Participation; // <--- AJOUTEZ CETTE LIGNE ICI
use Illuminate\Http\Request;
use Exception;
use App\Models\Agent; // N'oubliez pas d'importer le modèle en haut
use App\Models\SeminaireDocument;
use Illuminate\Support\Facades\Storage; // Utile pour supprimer des fichiers plus tard
use Illuminate\Support\Facades\DB; // Ajoutez cet import en haut du contrôleur
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\SeminaireParticipant; // N'oubliez pas d'importer le modèle en haut


class SeminaireController extends Controller
{
    /**
     * Liste des séminaires avec pagination
     */

    public function index()
{
    $now = now();

    // 1. Mise à jour physique des statuts en base de données avant l'affichage

    // Cas : "En cours" (entre début et fin, si pas déjà terminé/annulé)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_debut', '<=', $now)
        ->where('date_fin', '>=', $now)
        ->update(['statut' => 'en_cours']);

    // Cas : "Planifié" (si la date de début n'est pas encore arrivée)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_debut', '>', $now)
        ->update(['statut' => 'planifie']);

    // Cas : "En attente du rapport final" (si la date de fin est dépassée et pas de rapport)
    Seminaire::whereNotIn('statut', ['termine', 'annule'])
        ->where('date_fin', '<', $now)
        ->update(['statut' => 'en attente du rapport final']);

    // 2. Récupération des données pour la vue avec pagination
    $seminaires = Seminaire::select(
            'id',
            'titre',
            'organisateur',
            'lieu',
            'date_debut',
            'date_fin', // Ajouté pour les calculs éventuels dans la vue
            'statut',
            'nb_participants_prevu'
        )
        ->orderBy('date_debut', 'desc')
        ->paginate(15);

    return view('seminaires.index', compact('seminaires'));
}



    public function create()
    {
        // 1. On récupère les agents
        $agents = Agent::orderBy('last_name', 'asc')->get();

        // 2. On les envoie à la vue des séminaires
        return view('seminaires.create', compact('agents'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'                 => 'required|string|max:255',
            'organisateur'          => 'required|string|max:255',
            'lieu'                  => 'required|string|max:255',
            'date_debut'            => 'required|date',
            'date_fin'              => 'required|date|after_or_equal:date_debut',
            'nb_participants_prevu' => 'required|integer|min:0',
            'statut'                => 'required|string|max:255',
            'description'           => 'nullable|string',
        ]);

        try {
            Seminaire::create($validated);

            return redirect()->route('seminaires.index')
                ->with('success', 'Le séminaire a été programmé avec succès.');

        } catch (\Exception $e) {
            // Correction ici : l\'enregistrement avec un antislash
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }


        // App\Http\Controllers\SeminaireController.php

        public function show(Seminaire $seminaire)
    {
        $seminaire->load('participations.agent');

        // On récupère tous les agents triés par nom
        $agents = \App\Models\Agent::with('service:id,name')
            ->select('id', 'first_name', 'last_name', 'service_id', 'matricule')
            ->orderBy('last_name')
            ->get();

        return view('seminaires.show', compact('seminaire', 'agents'));
    }



        /**
         * Formulaire d'édition
         */
        public function edit(Seminaire $seminaire)
        {
            return view('seminaires.edit', compact('seminaire'));
        }

        /**
         * Mise à jour du séminaire
         */
        public function update(Request $request, Seminaire $seminaire)
{
    $validated = $request->validate([
        'titre'                 => 'required|string|max:255',
        'nb_participants_prevu' => 'required|integer|min:0',
        'organisateur'          => 'required|string|max:255',
        'lieu'                  => 'required|string|max:255',
        'date_debut'            => 'required|date',
        'date_fin'              => 'required|date|after_or_equal:date_debut',
        // Suppression de la règle "in:..." car le statut peut désormais être "en attente du rapport final"
        'statut'                => 'required|string|max:255',
        'description'           => 'nullable|string',
    ]);

    try {
        $seminaire->update($validated);

        return redirect()->route('seminaires.index')
            ->with('success', 'Le séminaire "' . $seminaire->titre . '" a été mis à jour avec succès.');

    } catch (\Exception $e) {
        // Log de l'erreur pour le développeur si besoin : \Log::error($e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Erreur lors de la modification : ' . $e->getMessage());
    }
}

        /**
         * Suppression
         */
        public function destroy(Seminaire $seminaire)
        {
            try {
                $seminaire->delete();
                return redirect()->route('seminaires.index')
                    ->with('success', 'Le séminaire a été annulé et supprimé.');
            } catch (Exception $e) {
                return back()->with('error', 'Impossible de supprimer ce séminaire.');
            }
        }


    public function uploadDocument(Request $request, $seminaireId)
    {
        $request->validate([
            // Ajout de mimes:pdf pour le type rapport pour plus de sécurité
            'fichier' => 'required|file|mimes:pdf,docx,jpg,png|max:10240',
            'type'    => 'required|in:presence,rapport,support'
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');

            // 1. Nettoyage du nom original pour éviter les espaces et caractères spéciaux
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $fileName = time() . '_' . $originalName;

            // 2. Déplacement physique
            $file->move(public_path('seminaires_rapport'), $fileName);

            // 3. Enregistrement en base de données (Utilisation de updateOrCreate pour le rapport)
            // Cela évite d'avoir 2 rapports pour un même séminaire
            SeminaireDocument::updateOrCreate(
                [
                    'seminaire_id' => $seminaireId,
                    'type'         => $request->type
                ],
                [
                    'nom_document' => $file->getClientOriginalName(),
                    'fichier_path' => $fileName, // On stocke UNIQUEMENT le nom du fichier
                ]
            );

            // 4. Mise à jour du statut si c'est un rapport
            if ($request->type === 'rapport') {
                $seminaire = Seminaire::findOrFail($seminaireId);
                // On s'assure que le statut correspond exactement à votre base
                $seminaire->update(['statut' => 'termine']);
            }

            return back()->with('success', 'Document ' . $request->type . ' archivé avec succès !');
        }

        return back()->with('error', 'Aucun fichier sélectionné.');
    }

    public function deleteDocument($seminaireId, $documentId)
        {
            $document = SeminaireDocument::findOrFail($documentId);

            // Suppression physique du fichier
            $filePath = public_path('seminaires_rapport/' . $document->fichier_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Suppression de l'enregistrement en base de données
            $document->delete();

            return back()->with('success', 'Document supprimé avec succès !');
        }


    public function dashboard()
{
    // On charge la relation 'documents' ET on compte les participants/documents en une seule requête
    $stats = Seminaire::with(['documents'])
        ->withCount([
            'participants as inscrits_total',
            'participants as presents_count' => function ($query) {
                $query->where('est_present', 1);
            },
            'documents as rapports_count' => function ($query) {
                $query->where('type', 'rapport');
            }
        ])
        ->orderBy('date_debut', 'desc')
        ->get();

    // Calculs globaux pour les compteurs du haut de page
    $totalSeminaires = $stats->count();

    // On vérifie le statut exact (avec espaces comme en base de données)
    $enAttenteRapport = $stats->where('statut', 'en attente du rapport final')->count();

    return view('seminaires.report', compact('stats', 'totalSeminaires', 'enAttenteRapport'));
}

    /**
     * Méthode pour le bouton de pointage rapide (Présent / Pointer)
     */
public function pointer(Request $request, $seminaireId, $participationId)
{
    $participation = SeminaireParticipant::where('id', $participationId)
                                         ->where('seminaire_id', $seminaireId)
                                         ->firstOrFail();

    $nouvelEtat = !$participation->est_present;

    // Récupération de l'heure saisie ou heure actuelle par défaut
    $heureSaisie = $request->input('heure_manuelle');

    $participation->update([
        'est_present'    => $nouvelEtat,
        // Si on pointe, on prend l'heure du formulaire, sinon null
        'heure_pointage' => $nouvelEtat ? ($heureSaisie ?? now()) : null,
        'email'          => $request->input('email', $participation->email),
        'telephone'      => $request->input('telephone', $participation->telephone),
    ]);

    return back()->with('success', 'Pointage enregistré à la date choisie.');
}




    /**
     * Méthode pour la saisie manuelle Date & Heure (La disquette)
     */
    public function updatePointage(Request $request, $seminaireId, $participantId)
    {
        // 1. Validation stricte
        $request->validate([
            'date_pointage'  => 'required|date_format:Y-m-d',
            'heure_presence' => 'required',
        ]);

        try {
            // 2. Construction propre du datetime
            $fullDatetime = $request->date_pointage . ' ' . $request->heure_presence . ':00';

            // 3. Mise à jour ou Insertion
            DB::table('seminaire_emargements')->updateOrInsert(
                [
                    'seminaire_id'   => $seminaireId,
                    'participant_id' => $participantId,
                    'date_pointage'  => $request->date_pointage,
                ],
                [
                    'heure_pointage' => $fullDatetime,
                    'est_present'    => true,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]
            );

            return back()->with('success', 'Pointage enregistré avec succès !');
        } catch (\Exception $e) {
            // En cas d'erreur SQL, on affiche le message réel
            return back()->withErrors(['error' => 'Erreur SQL : ' . $e->getMessage()]);
        }
    }

    public function showEmargement(Request $request, $id)
    {
        $seminaire = Seminaire::findOrFail($id);

        // 1. Générer la liste des dates (du début à la fin du séminaire)
        $debut = \Carbon\Carbon::parse($seminaire->date_debut);
        $fin = \Carbon\Carbon::parse($seminaire->date_fin);
        $jours = [];

        // On utilise copy() pour ne pas modifier l'objet original dans la boucle
        for ($date = $debut->copy(); $date->lte($fin); $date->addDay()) {
            $jours[] = $date->format('Y-m-d');
        }

        // 2. Déterminer le jour affiché (par défaut le 1er jour du séminaire)
        $dateSelectionnee = $request->get('date_pointage', $jours[0] ?? date('Y-m-d'));

        // 3. Requête avec concaténation du nom et prénom de l'agent
        $participants = DB::table('seminaire_participants as sp')
            ->leftJoin('agents as a', 'sp.agent_id', '=', 'a.id')
            ->leftJoin('seminaire_emargements as se', function ($join) use ($dateSelectionnee) {
                $join->on('sp.id', '=', 'se.participant_id')
                    ->where('se.date_pointage', '=', $dateSelectionnee);
            })
            ->where('sp.seminaire_id', $id)
            ->select(
                'sp.id',
                'sp.nom_externe',
                'sp.organisme_externe',
                // Concaténation SQL pour MariaDB/MySQL
                DB::raw("CONCAT(a.first_name, ' ', a.last_name) as nom_agent"),
                'se.heure_pointage',
                'se.est_present'
            )
            ->get();

        return view('seminaires.emargement', compact('seminaire', 'jours', 'dateSelectionnee', 'participants'));
    }


    // 1. Affiche le QR Code à projeter sur écran ou imprimer
    public function showQrCode(Seminaire $seminaire)
    {
        // Test temporaire avec l'ID
        $url = route('seminaires.public.scan', $seminaire->id);


        $qrCode = QrCode::size(300)
            ->style('round')
            ->eye('square')
            ->color(10, 50, 150) // Bleu foncé pro
            ->generate($url);

        return view('seminaires.qrcode', compact('qrCode', 'seminaire'));
    }

    // 2. Page affichée sur le téléphone du participant
    public function scanEmargement($uuid)
    {
        $seminaire = Seminaire::where('uuid', $uuid)->firstOrFail();
        return view('seminaires.public_emarge', compact('seminaire'));
    }


    public function validerEmargement(Request $request, $uuid)
    {
        // 1. Validation des données reçues du mobile
        $request->validate([
            'participant_id' => 'required|exists:seminaire_participants,id',
            'telephone'      => 'required|string|min:8',
            'email'          => 'nullable|email'
        ]);

        // 2. Récupération du séminaire via l'UUID
        $seminaire = Seminaire::where('uuid', $uuid)->firstOrFail();

        // 3. Mise à jour du pointage
        $updated = DB::table('seminaire_participants')
            ->where('id', $request->participant_id)
            ->where('seminaire_id', $seminaire->id)
            ->update([
                'est_present'    => true,
                'heure_pointage' => now(),
                'telephone'      => $request->telephone,
                'email'          => $request->email,
                'updated_at'     => now()
            ]);

        if ($updated) {
            return back()->with('success', 'Votre présence a été enregistrée avec succès !');
        }

        return back()->with('error', 'Impossible de valider votre présence. Veuillez contacter l\'administrateur.');
    }
}
