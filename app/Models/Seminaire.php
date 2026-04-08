<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\SeminaireParticipant;



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
        'uuid', // <--- AJOUTEZ CECI
    ];

    protected static function booted()
    {
        static::creating(fn($s) => $s->uuid = (string) \Illuminate\Support\Str::uuid());
    }


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

    /**
     * Relation avec les documents
     */
    public function documents()
    {
        // On lie le séminaire à la table seminaires_documents
        return $this->hasMany(SeminaireDocument::class, 'seminaire_id');
    }

 
// app/Models/Seminaire.php
public function participants() {
    // Utilise la table définie dans le modèle SeminaireParticipant
    return $this->hasMany(SeminaireParticipant::class, 'seminaire_id');
}


}
