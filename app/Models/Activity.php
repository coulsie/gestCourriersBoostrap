<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Activity extends Model
{
    protected $fillable = [
        'service_id',
        'report_date',
        'content',
        'observation' // Optionnel : pour les notes de synthèse
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    /**
     * Relation avec le service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Filtre par période dynamique (Hebdo, Mensuel, Trimestriel...)
     */
    public function scopeForPeriod(Builder $query, string $type): void
{
    $now = Carbon::now();

    match ($type) {
        'daily'     => $query->whereDate('report_date', $now),

        // Optimisation : Utilise les plages de dates (index-friendly)
        'weekly'    => $query->whereBetween('report_date', [
                           $now->copy()->startOfWeek(),
                           $now->copy()->endOfWeek()
                       ]),

        'monthly'   => $query->whereBetween('report_date', [
                           $now->copy()->startOfMonth(),
                           $now->copy()->endOfMonth()
                       ]),

        'quarterly' => $query->whereBetween('report_date', [
                           $now->copy()->startOfQuarter(),
                           $now->copy()->endOfQuarter()
                       ]),

        'semester'  => $this->scopeForSemester($query, $now),

        'yearly'    => $query->whereBetween('report_date', [
                           $now->copy()->startOfYear(),
                           $now->copy()->endOfYear()
                       ]),

        default     => $query
    };
}


    /**
     * Logique spécifique pour le semestre
     */
    private function scopeForSemester($query, $now)
    {
        if ($now->month <= 6) {
            return $query->whereBetween('report_date', [$now->startOfYear(), $now->copy()->month(6)->endOfMonth()]);
        }
        return $query->whereBetween('report_date', [$now->copy()->month(7)->startOfMonth(), $now->endOfYear()]);
    }


}
