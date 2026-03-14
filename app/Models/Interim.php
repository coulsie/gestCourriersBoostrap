<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User; // Assurez-vous que cette ligne est présente en haut

class Interim extends Model
{
    // Indiquer le nom de la table si elle est différente du pluriel anglais (optionnel ici)
    protected $table = 'interims';

    // Champs autorisés pour l'assignation de masse (Mass Assignment)
    protected $fillable = [
        'agent_id',
        'interimaire_id',
        'user_id',
        'date_debut',
        'date_fin',
        'motif',
        'is_active',
    ];

    // Cast des types de données (Laravel gérera les dates et le booléen automatiquement)
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relations (Exemples basés sur vos clés étrangères)
     */

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    
public function interimaire()
{
    // On précise la clé étrangère 'interimaire_id'
    return $this->belongsTo(Agent::class, 'interimaire_id');
}
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

