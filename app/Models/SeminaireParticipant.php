<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeminaireParticipant extends Model
{
    protected $fillable = [
        'seminaire_id',
        'agent_id',
        'nom_externe',
        'organisme_externe',
        'est_present',
        'heure_pointage',
        'email',
        'telephone',
        'seminaireparticipant_id'
    ];



    protected $casts = [
        'est_present' => 'boolean',
        'heure_pointage' => 'datetime',
    ];


    /**
     * Relation avec le séminaire parent
     */
    public function seminaire(): BelongsTo
    {
        return $this->belongsTo(Seminaire::class);
    }

    /**
     * Relation avec l'agent (Interne)
     * Utilise votre table 'agents' existante
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Accesseur pour obtenir le nom complet du participant (Interne ou Externe)
     */
    public function getNomCompletAttribute(): string
    {
        if ($this->agent_id) {
            return $this->agent->first_name . ' ' . $this->agent->last_name;
        }
        return $this->nom_externe;
    }

    /**
     * Accesseur pour obtenir la structure d'origine (Service ou Organisme)
     */
    public function getStructureAttribute(): string
    {
        if ($this->agent_id) {
            return $this->agent->service->name ?? 'Service inconnu';
        }
        return $this->organisme_externe ?? 'Externe';
    }

    /**
     * Vérifie si le participant est un agent interne
     */
    public function estInterne(): bool
    {
        return !is_null($this->agent_id);
    }

    /**
     * Scope pour filtrer les présents uniquement
     */
    public function scopePresents($query)
    {
        return $query->where('est_present', true);
    }
}
