<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory;

    /**
     * Les attributs que l'on peut remplir massivement.
     */
    protected $fillable = [
        'name',
        'holiday_date',
        'description',
        'is_recurring'
    ];

    /**
     * Conversion automatique des types (Casting).
     * En Laravel 12, on utilise la méthode casts().
     */
    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
            'is_recurring' => 'boolean',
            
        ];
    }

    /**
     * Scope pour récupérer les jours fériés d'une année spécifique.
     */
    public function scopeOfYear($query, $year)
    {
        return $query->whereYear('holiday_date', $year);
    }
}
