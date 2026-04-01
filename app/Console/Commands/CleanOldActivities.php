<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Carbon\Carbon;

class CleanOldActivities extends Command
{
    // Le nom de la commande à taper dans le terminal
    protected $signature = 'activities:clean';

    // La description de ce que fait la commande
    protected $description = 'Supprime les rapports d\'activités datant de plus de 2 ans';

    public function handle()
    {
        $limitDate = Carbon::now()->subYears(2);

        // On compte combien on va en supprimer pour le log
        $count = Activity::where('report_date', '<', $limitDate)->count();

        if ($count > 0) {
            Activity::where('report_date', '<', $limitDate)->delete();
            $this->info("Nettoyage réussi : $count anciens rapports supprimés.");
        } else {
            $this->info("Aucun ancien rapport à supprimer.");
        }
    }
}
