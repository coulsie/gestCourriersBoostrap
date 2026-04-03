<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminaireDocument extends Model
{
    protected $fillable = ['seminaire_id', 'nom_document', 'fichier_path', 'type'];

    public function seminaire()
    {
        return $this->belongsTo(Seminaire::class);
    }
}
