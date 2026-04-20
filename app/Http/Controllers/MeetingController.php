<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Mail\ReunionProgrammee;
use Illuminate\Support\Facades\Mail;


class MeetingController extends Controller
{
    public function hebdo()
{
    // Définition de la plage de la semaine actuelle
    $debutSemaine = now()->startOfWeek()->startOfDay();
    $finSemaine = now()->endOfWeek()->endOfDay();

    // 1. Réunions de la semaine en cours
    // On charge 'participants.agent' pour les internes et 'listeExternes' pour les invités

        // Modifiez la ligne 20 comme ceci :
        $reunions = Meeting::with(['animateur', 'redacteur', 'participants', 'listeExternes'])
            ->whereBetween('date_heure', [$debutSemaine, $finSemaine])
            ->orderBy('date_heure', 'asc')
            ->get();


        // 2. Réunions hors-semaine (Historique complet)
        $autresReunions = Meeting::with(['animateur', 'redacteur', 'participants', 'listeExternes'])
        ->whereNotBetween('date_heure', [$debutSemaine, $finSemaine])
        ->orderBy('date_heure', 'desc')
        ->get();

    // Calcul des réunions en retard (À CLÔTURER)
    $nbRetards = $reunions->where('status', 'programmee')
                         ->filter(fn($r) => \Carbon\Carbon::parse($r->date_heure)->isPast())
                         ->count();

    // Envoi à la vue
    return view('Reunions.hebdo', compact('reunions', 'autresReunions', 'nbRetards'));
}



    public function create()
{
    // On trie par le nom de famille (last_name)
    $agents = \App\Models\Agent::orderBy('last_name', 'asc')->get();
    return view('Reunions.create', compact('agents'));
}


    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'objet' => 'required|string|max:255',
            'date_heure' => 'required|date',
            'animateur_id' => 'required|exists:agents,id',
            'redacteur_id' => 'required|exists:agents,id',
            'participants' => 'nullable|array',
            'externes' => 'nullable|array',
        ]);

        $reunion = \DB::transaction(function () use ($request) {
            // 2. Création réunion
            $reunion = \App\Models\Meeting::create($request->only([
                'objet',
                'date_heure',
                'animateur_id',
                'redacteur_id',
                'lieu',
                'ordre_du_jour'
            ]));

            // 3. Internes (avec timestamps pour ta table pivot)
            if ($request->has('participants')) {
                $now = now();
                $participants = collect($request->participants)->mapWithKeys(function ($id) use ($now) {
                    return [$id => ['created_at' => $now, 'updated_at' => $now]];
                });
                $reunion->participants()->attach($participants);
            }

            // 4. Externes
            if ($request->has('externes')) {
                foreach ($request->externes as $externe) {
                    if (!empty($externe['nom_complet'])) {
                        $reunion->listeExternes()->create($externe);
                    }
                }
            }
            return $reunion;
        });

        // 5. ENVOI DES EMAILS
        $this->envoyerNotifications($reunion);

        return redirect()->route('reunions.hebdo')->with('success', 'Réunion enregistrée et invitations envoyées !');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function show(Meeting $reunion)
    {
        return view('Reunions.show', compact('reunion'));
    }



    public function edit($id)
    {
        $reunion = Meeting::with(['participants', 'listeExternes'])->findOrFail($id);
        $agents = Agent::all();
        return view('Reunions.edit', compact('reunion', 'agents'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id)
    {
        $reunion = Meeting::findOrFail($id);

        \DB::transaction(function () use ($request, $reunion, $id) {
            $data = $request->only(['objet', 'date_heure', 'lieu', 'animateur_id', 'redacteur_id', 'status', 'ordre_du_jour']);

            // Gestion fichiers
            if ($request->hasFile('presence_file')) {
                $fileName = 'presence_' . time() . '_' . $request->file('presence_file')->getClientOriginalName();
                $request->file('presence_file')->move(public_path('Rapport_Reunions'), $fileName);
                $data['presence_file'] = 'Rapport_Reunions/' . $fileName;
            }

            if ($request->hasFile('report_file')) {
                $fileName = 'rapport_' . time() . '_' . $request->file('report_file')->getClientOriginalName();
                $request->file('report_file')->move(public_path('Rapport_Reunions'), $fileName);
                $data['report_file'] = 'Rapport_Reunions/' . $fileName;
            }

            $reunion->update($data);

            // Mise à jour Internes
            \DB::table('meeting_participants')->where('meeting_id', $id)->delete();
            if ($request->has('participants')) {
                $now = now();
                $dataInternes = collect($request->participants)->map(fn($agent_id) => [
                    'meeting_id' => $id,
                    'agent_id' => $agent_id,
                    'created_at' => $now,
                    'updated_at' => $now
                ])->toArray();
                \DB::table('meeting_participants')->insert($dataInternes);
            }

            // Mise à jour Externes
            $reunion->listeExternes()->delete();
            if ($request->has('externes')) {
                foreach ($request->externes as $ex) {
                    if (!empty($ex['nom_complet'])) $reunion->listeExternes()->create($ex);
                }
            }
        });

        // ENVOI DES EMAILS (si la réunion est modifiée)
        $this->envoyerNotifications($reunion->fresh());

        return redirect()->route('reunions.hebdo')->with('success', 'Mise à jour réussie et notifications envoyées.');
    }

    /**
     * Fonction privée pour centraliser l'envoi des emails
     */
    private function envoyerNotifications(Meeting $meeting)
    {
        // Récupération des destinataires
        $emailsInternes = $meeting->participants->pluck('email_professionnel')->filter()->toArray();
        $emailsExternes = $meeting->listeExternes->pluck('email')->filter()->toArray();
        $destinataires = array_unique(array_merge($emailsInternes, $emailsExternes));

        if (empty($destinataires)) return;

        if ($meeting->status !== 'terminee') {
            // CAS 1 : Convocation / Mise à jour de programme
            foreach ($destinataires as $email) {
                Mail::to($email)->queue(new \App\Mail\ReunionProgrammee($meeting));
            }
        } elseif ($meeting->status === 'terminee' && ($meeting->report_file || $meeting->presence_file)) {
            // CAS 2 : Envoi des PV et Listes de présence
            foreach ($destinataires as $email) {
                Mail::to($email)->queue(new \App\Mail\ReunionTerminee($meeting));
            }
        }
    }

    /**
     * Supprimer la réunion
     */
    public function destroy(Meeting $reunion)
    {
        // 1. Détacher d'abord les participants dans la table pivot (sécurité)
        $reunion->participants()->detach();

        // 2. Supprimer la réunion de la base de données
        $reunion->delete();

        // 3. Rediriger avec un message de succès éclatant
        return redirect()->route('reunions.hebdo')
            ->with('success', 'La réunion a été supprimée avec succès.');
    }

        public function etat(Request $request)
    {
        // Valeurs par défaut : mois en cours
        $debut = $request->filled('date_debut') ? \Carbon\Carbon::parse($request->date_debut)->startOfDay() : now()->startOfMonth();
        $fin = $request->filled('date_fin') ? \Carbon\Carbon::parse($request->date_fin)->endOfDay() : now()->endOfMonth();
        $statut = $request->get('status');

        $query = Meeting::with(['animateur', 'redacteur', 'participants'])
            ->whereBetween('date_heure', [$debut, $fin]);

        // Filtre optionnel par statut
        if ($request->filled('status')) {
            $query->where('status', $statut);
        }

        $reunions = $query->orderBy('date_heure', 'asc')->get();

        return view('Reunions.etat', compact('reunions', 'debut', 'fin', 'statut'));
    }

    public function listePresence($id)
    {
        // 1. On charge la réunion
        $reunion = Meeting::with(['participants', 'listeExternes'])->findOrFail($id);

        // 2. Préparation des Internes
        $internes = $reunion->participants->map(function ($agent) {
            return (object)[
                'nom' => strtoupper($agent->last_name) . ' ' . $agent->first_name,
                'origine' => 'DSESF',
                // Remplacement de $p par $agent ici
                'fonction' => ($agent->status ?? 'Agent') . " | " . $agent->email_professionnel . " | " . $agent->phone_number,
                'contact' => $agent->phone_number,
            ];
        });

        // 3. Préparation des Externes
        $externes = $reunion->listeExternes->map(function ($e) {
            return (object)[
                'nom' => strtoupper($e->nom_complet),
                'origine' => $e->origine,
                'fonction' => ($e->fonction) . " | " . $e->email . " | " . $e->telephone,
                'contact' => $e->telephone . ' / ' . $e->email
            ];
        });

        // Fusion des listes
        $listeParticipants = $internes->concat($externes);

        return view('Reunions.print_presence', compact('reunion', 'listeParticipants'));
    }
}
