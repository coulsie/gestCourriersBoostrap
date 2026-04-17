<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingParticipant extends Model
{
    // Indiquer le nom de la table si ce n'est pas le pluriel automatique
    protected $table = 'meeting_participants';
    public $timestamps = false;


    // Autoriser l'assignation de masse
    protected $fillable = [
        'meeting_id',
        'agent_id'
    ];
    
    /**
     * Relation vers l'Agent.
     * Permet d'accéder à $participant->agent->email et $participant->agent->phone_number
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * Relation vers la Réunion (Meeting).
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
