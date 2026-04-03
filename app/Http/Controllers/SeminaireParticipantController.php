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


    }
