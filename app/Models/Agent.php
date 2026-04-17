<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Service;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Agent extends Model
{
    use HasFactory;
    use HasRoles;

    /**
     * Les attributs qui peuvent être massivement assignés (Mass Assignable).
     * Ces noms de colonnes doivent correspondre à ceux définis dans votre migration 'agents'.
     */
    protected $fillable = [
        'email_professionnel',
        'matricule',
        'first_name',
        'last_name',
        'status',
        'sexe',
        'date_of_birth',
        'Place_birth',
        'photo',
        'email',
        'phone_number',
        'address',
        'Emploi',
        'Grade',
        'Date_Prise_de_service',
        'Personne_a_prevenir',
        'Contact_personne_a_prevenir',
        'service_id', // Clé étrangère vers le service d'affectation
        'user_id',    // Clé étrangère optionnelle vers le compte utilisateur pour l'authentification
        ];

    /**
     * Définit la relation : un Agent appartient à un seul Service.
     * C'est la relation inverse de Service::hasMany(Agent).
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function estResponsable()
    {
        return in_array($this->status, [
            'Chef de service',
            'Sous-directeur',
            'Directeur',
            'Conseiller Technique',
            'Conseiller Spécial'
        ]);
    }


    // App\Models\Agent.php
    public function estChef()
    {
        return \App\Models\Service::where('head_id', $this->id)->exists();
    }



    /**
     * Définit la relation : un Agent appartient à un seul User (pour la connexion).
     * C'est une relation optionnelle (nullable) vers le modèle User par défaut de Laravel.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Définit la relation : un Agent peut être responsable de plusieurs Directions.
     * Inverse de la relation Direction::belongsTo(Agent, 'head_id').
     */
    public function directionsResponsable(): HasMany
    {
        // L'agent est le responsable (head_id) de plusieurs directions
        return $this->hasMany(Direction::class, 'head_id');
    }

    /**
     * Définit la relation : un Agent peut être responsable de plusieurs Services.
     * Inverse de la relation Service::belongsTo(Agent, 'head_id').
     */
    public function servicesResponsable(): HasMany
    {
        // L'agent est le responsable (head_id) de plusieurs services
        return $this->hasMany(Service::class, 'head_id');
    }
     public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }
     public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);

    }
     public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
        
                public function imputations()
        {
            return $this->belongsToMany(Imputation::class, 'agent_imputation');
        }

        protected function firstName(): Attribute
        {
            return Attribute::make(
                set: fn ($value) => Str::ucfirst(Str::lower($value)),
            );
        }
                protected function lastName(): Attribute
        {
            return Attribute::make(
                set: fn ($value) => mb_strtoupper($value, 'UTF-8'),
            );
        }

public function getStatutActuelAttribute()
{
    // Vérifier s'il y a un intérim actif pour cet agent aujourd'hui
    $interim = \App\Models\Interim::where('interimaire_id', $this->id)
        ->where('is_active', true)
        ->whereDate('date_debut', '<=', now())
        ->whereDate('date_fin', '>=', now())
        ->first();

    if ($interim) {
        // Retourne le statut de la personne qu'il remplace
        return $interim->agent->status;
    }

    return $this->status; // Retourne son propre statut sinon
}

 /**
     * Réunions où l'agent est l'animateur.
     */
    public function meetingsAnimees(): HasMany
    {
        return $this->hasMany(Meeting::class, 'animateur_id');
    }

    /**
     * Réunions où l'agent est le rédacteur.
     */
    public function meetingsRedigees(): HasMany
    {
        return $this->hasMany(Meeting::class, 'redacteur_id');
    }

    /**
     * Réunions auxquelles l'agent participe (en tant que simple participant).
     */
    public function participations(): BelongsToMany
    {
        return $this->belongsToMany(Meeting::class, 'meeting_participants');
    }

    public function getNomCompletAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

}
