<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;


class AuditLogController extends Controller
{

 /**
     * Affiche le journal avec pagination
     */
    public function journalLogs()
    {
        // Vérification de sécurité (Rôles autorisés)
        if (!Auth::user()->hasAnyRole(['admin', 'Superviseur', 'Admin'])) {
            abort(403, "Action non autorisée.");
        }

        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.logs', compact('logs'));
    }

     /**
     * Supprime une seule ligne du journal
     */


    public function destroy($id)
    {
        // Utilisons la même vérification que pour votre fonction journalLogs()
        if (!auth::user()->hasAnyRole(['admin', 'Superviseur'])) {
            abort(403, "Action réservée à l'Administrateur et Superviseur.");
        }

        $log = \App\Models\AuditLog::findOrFail($id);
        $log->delete();

        return back()->with('success', 'Log supprimé avec succès.');
    }

 /**
     * Vide TOUT le journal (Purge complète)
     */
    public function clearAll()
    {
        if (!Auth::user()->hasAnyRole(['admin', 'Admin'])) {
            abort(403, "Action réservée à l'administrateur principal.");
        }

        // Utiliser truncate() pour vider la table et réinitialiser les IDs
        AuditLog::truncate();

        return back()->with('success', 'Le journal a été entièrement vidé.');
    }

}
