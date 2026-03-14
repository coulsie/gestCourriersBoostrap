<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Interim;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // 1. Gate universelle pour vérifier un rôle (Direct ou par Intérim)
        Gate::define('has-role', function (User $user, string $roleAttendu) {
            $agent = $user->agent;

            if (!$agent) return false;

            // A. Vérification directe (trim gère les espaces accidentels en BDD)
            if (trim($agent->status) === $roleAttendu) {
                return true;
            }

            // B. Vérification de l'intérim actif aujourd'hui
            return Interim::where('interimaire_id', $agent->id)
                ->where('is_active', true)
                ->whereDate('date_debut', '<=', now())
                ->whereDate('date_fin', '>=', now())
                ->whereHas('agent', function($query) use ($roleAttendu) {
                    $query->where('status', $roleAttendu);
                })
                ->exists();
        });

        // 2. Gate spécifique pour la signature direction
        Gate::define('signer-courrier-direction', function (User $user) {
            // On utilise la gate 'has-role' définie juste au-dessus
            // Note : Laravel permet d'appeler check() pour réutiliser une Gate
            return Gate::check('has-role', 'Directeur');
        });

        // 3. Gate pour voir les utilisateurs (seulement pour la Direction)
        Gate::define('voir-utilisateurs', function (User $user) {
            return Gate::check('has-role', 'Directeur');
        });
    }
}
