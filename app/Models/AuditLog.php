<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    // Autoriser le remplissage de tous les champs
    protected $guarded = [];


    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];


    // Relation pour savoir quel utilisateur a fait l'action
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
