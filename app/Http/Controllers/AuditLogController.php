<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    /**
     * Affiche le journal avec filtres et pagination
     */
    public function journalLogs(Request $request)
    {
        // Vérification de sécurité
        if (!Auth::user()->hasAnyRole(['admin', 'Superviseur', 'Admin'])) {
            abort(403, "Action non autorisée.");
        }

        $query = AuditLog::with('user');

        // --- FILTRES DE RECHERCHE ---

        // 1. Recherche par nom d'utilisateur ou IP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('event', 'like', "%{$search}%");
            });
        }

        // 2. Filtre par type d'événement (Created, Updated, etc.)
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // 3. Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        return view('admin.logs', compact('logs'));
    }

    /**
     * Supprime une seule ligne du journal
     */
    public function destroy($id)
    {
        if (!auth::user()->hasAnyRole(['admin', 'Superviseur'])) {
            abort(403, "Action réservée à l'Administrateur et Superviseur.");
        }

        $log = AuditLog::findOrFail($id);
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

        // Note: Truncate peut échouer si vous avez des clés étrangères actives.
        // Si c'est le cas, utilisez AuditLog::query()->delete();
        AuditLog::truncate();

        return back()->with('success', 'Le journal a été entièrement vidé.');
    }
}
