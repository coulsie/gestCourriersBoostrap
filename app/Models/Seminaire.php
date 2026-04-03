<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seminaire extends Model
{
    protected $fillable = [
        'titre',
        'organisateur',
        'description',
        'lieu',
        'date_debut',
        'date_fin',
        'statut',
        'nb_participants_prevu', // <--- Doit être ici
    ];



    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin'   => 'datetime',
    ];

    public function agents() {
        return $this->belongsToMany(Agent::class, 'seminaire_participants')
                    ->withPivot('est_present', 'heure_pointage');
    }

    // Pour le rapport : Liste des agents qui étaient censés être là mais sont absents (via votre table absences)
    public function agentsIndisponibles() {
        return $this->agents()->whereHas('absences', function($query) {
            $query->where('date_debut', '<=', $this->date_debut)
                ->where('date_fin', '>=', $this->date_debut)
                ->where('approuvee', 1);
        });
    }

// App\Models\Seminaire.php

    public function participations()
    {
        // Vérifiez que le nom du modèle est bien SeminaireParticipant
        return $this->hasMany(SeminaireParticipant::class);
    }

/**
     * Relation avec les participants
     */
    public function participants()
    {
        // On lie le séminaire à la table seminaires_participants
        return $this->hasMany(SeminaireParticipant::class, 'seminaire_id');
    }

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        // On lie le séminaire à la table seminaires_documents
        return $this->hasMany(SeminaireDocument::class, 'seminaire_id');
    }


}
