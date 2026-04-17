<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingExterne extends Model
{
    // Nom de la table
    protected $table = 'meeting_externes';

    // Champs autorisés pour l'ajout/modification
    protected $fillable = [
        'meeting_id',
        'nom_complet',
        'origine',
        'fonction',
        'email',
        'telephone'
    ];
    

    /**
     * Relation vers la Réunion (Meeting).
     * Un participant externe appartient à une réunion spécifique.
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
