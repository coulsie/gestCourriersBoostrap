<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meeting extends Model
{

protected $fillable = [
    'objet', 'date_heure', 'lieu', 'animateur_id', 'redacteur_id',
    'participants', 'externes', 'ordre_du_jour',
    'status', 'presence_file', 'report_file' // Nouveaux champs
];


    /**
     * Casts pour Laravel 12.
     */
    protected function casts(): array
    {
        return [
            'date_heure' => 'datetime',
            'duree_minutes' => 'integer',
        ];
    }
    protected $casts = [
        'externes' => 'array',
        'date_heure' => 'datetime',
    ];


    /**
     * L'agent qui anime la réunion.
     */
    public function animateur(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'animateur_id');
    }

    /**
     * L'agent qui rédige le compte-rendu.
     */
    public function redacteur(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'redacteur_id');
    }

    /**
     * Les agents participants (via la table pivot meeting_participants).
     */

    public function participants()
    {
        // Relation vers le modèle MeetingParticipant
        return $this->hasMany(MeetingParticipant::class, 'meeting_id');
    }



// App/Models/Meeting.php


public function listeExternes() {
    return $this->hasMany(MeetingExterne::class, 'meeting_id');
}


}
