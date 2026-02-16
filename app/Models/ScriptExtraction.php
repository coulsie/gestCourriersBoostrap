<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScriptExtraction extends Model
{

   // Indique le nom exact de la table créée dans la migration
protected $table = 'scripts_extraction';

protected $fillable = ['nom', 'description', 'code', 'parametres'];


protected $casts = [
    'parametres' => 'array', // Convertit automatiquement le JSON en tableau PHP

];

}
