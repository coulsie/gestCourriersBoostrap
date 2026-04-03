<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Activity extends Model
{
    protected $fillable = [
        'service_id',
        'report_date',
        'content',
        'observation'
    ];

    protected $casts = [
        // Utiliser 'date' suffit, mais assurez-vous que c'est bien mappé
        'report_date' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopeForPeriod(Builder $query, string $type): void
    {
        $now = Carbon::now();

        match ($type) {
            'daily'     => $query->whereDate('report_date', $now->toDateString()),

            'weekly'    => $query->whereBetween('report_date', [
                               $now->startOfWeek()->toDateString(),
                               $now->endOfWeek()->toDateString()
                           ]),

            'monthly'   => $query->whereBetween('report_date', [
                               $now->startOfMonth()->toDateString(),
                               $now->endOfMonth()->toDateString()
                           ]),

            'quarterly' => $query->whereBetween('report_date', [
                               $now->startOfQuarter()->toDateString(),
                               $now->endOfQuarter()->toDateString()
                           ]),

            'semester'  => $this->applySemesterScope($query, $now),

            'yearly'    => $query->whereBetween('report_date', [
                               $now->startOfYear()->toDateString(),
                               $now->endOfYear()->toDateString()
                           ]),

            default     => $query
        };
    }

    /**
     * Logique de semestre séparée pour la clarté
     */
    private function applySemesterScope(Builder $query, Carbon $now): Builder
    {
        if ($now->month <= 6) {
            return $query->whereBetween('report_date', [
                $now->copy()->startOfYear()->toDateString(),
                $now->copy()->month(6)->endOfMonth()->toDateString()
            ]);
        }

        return $query->whereBetween('report_date', [
            $now->copy()->month(7)->startOfMonth()->toDateString(),
            $now->copy()->endOfYear()->toDateString()
        ]);
    }
}
