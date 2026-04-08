<?php

namespace App\Http\Controllers;

use App\Models\{Seminaire, Agent, Service, SeminaireParticipant};
use Illuminate\Http\Request;

class SeminaireParticipantController extends Controller
{
    /**
     * Inscription massive d'agents par Service
     */
    public function ajouterParService(Request $request, Seminaire $seminaire)
    {
        $serviceId = $request->input('service_id');
        $agents = Agent::where('service_id', $serviceId)->get();

        foreach ($agents as $agent) {
            // Éviter les doublons
            SeminaireParticipant::firstOrCreate([
                'seminaire_id' => $seminaire->id,
                'agent_id'     => $agent->id,
            ]);
        }

        return back()->with('success', count($agents) . " agents du service ont été inscrits.");
    }


    /**
     * Ajout d'un participant externe
     */
    public function ajouterExterne(Request $request, Seminaire $seminaire)
    {
        $validated = $request->validate([
            'nom_externe' => 'required|string',
            'organisme_externe' => 'required|string',
        ]);

        $seminaire->participations()->create($validated);

        return back()->with('success', 'Participant externe ajouté.');
    }

/**
 * Inscription massive d'agents sélectionnés par cases à cocher
 */
        public function ajouterMultiplesAgents(Request $request, Seminaire $seminaire)
        {
            // 1. Récupérer le tableau d'IDs des agents cochés
            $agentIds = $request->input('agent_ids', []);

            if (empty($agentIds)) {
                return back()->with('error', 'Veuillez sélectionner au moins un agent.');
            }

            try {
                foreach ($agentIds as $id) {
                    // updateOrCreate évite les doublons si l'agent est déjà inscrit
                    \App\Models\SeminaireParticipant::updateOrCreate([
                        'seminaire_id' => $seminaire->id,
                        'agent_id'     => $id
                    ]);
                }

                return back()->with('success', count($agentIds) . ' agents ont été inscrits avec succès.');

            } catch (\Exception $e) {
                return back()->with('error', 'Erreur lors de l\'inscription : ' . $e->getMessage());
            }
        }

        /**
         * Pointage (Émargement) individuel
         */
        public function pointerPresence(Request $request, $seminaireId, $participationId)
        {
            // On récupère l'objet manuellement via son ID
            $participation = \App\Models\SeminaireParticipant::findOrFail($participationId);

            $participation->update([
                'est_present'    => !$participation->est_present,
                'heure_pointage' => !$participation->est_present ? now() : null
            ]);

            return back()->with('success', 'Statut de présence mis à jour.');
        }

       public function updatePointage(Request $request, $seminaireId, $participantId)
{
    $participation = SeminaireParticipant::where('id', $participantId)
                                         ->where('seminaire_id', $seminaireId)
                                         ->firstOrFail();

    // 1. Fusion de la date et de l'heure saisies
    if ($request->filled('date_presence') && $request->filled('heure_presence')) {
        // Crée une chaîne "YYYY-MM-DD HH:MM:00"
        $dateHeureSaisie = $request->date_presence . ' ' . $request->heure_presence . ':00';
    } else {
        $dateHeureSaisie = now(); // Par défaut si vide
    }

    // 2. Mise à jour (On force aussi est_present à true puisqu'on définit une heure)
    $participation->update([
        'est_present'    => true,
        'heure_pointage' => $dateHeureSaisie,
        'email'          => $request->input('email', $participation->email),
        'telephone'      => $request->input('telephone', $participation->telephone),
    ]);

    return back()->with('success', 'Pointage manuel enregistré avec succès.');
}



    }
