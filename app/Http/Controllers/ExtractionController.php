<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicQueryExport;
use Illuminate\Support\Facades\Config;
use App\Models\ScriptExtraction;

class ExtractionController extends Controller
{
    public function index(Request $request)
    {
        $scripts = ScriptExtraction::orderBy('nom')->get();
        $data = null;
        $type = $request->input('connection_type', 'mariadb');
        $query = $request->input('code', ''); // On utilise 'code' par défaut

        return view('extraction.index', compact('scripts', 'data', 'type', 'query'));
    }

    public function execute(Request $request)
    {
        // --- ACTION : ENREGISTRER / MODIFIER ---
        if ($request->input('action') === 'save') {
            $request->validate([
                'nom' => 'required|string|max:255',
                'code' => 'required' // C'est le textarea du script SQL
            ]);

            ScriptExtraction::updateOrCreate(
                ['id' => $request->input('script_id')], // Cherche par ID pour modifier
                [
                    'nom'  => $request->input('nom'),
                    'code' => $request->input('code'), // Stockage du script long texte
                    'description' => $request->input('description'),
                    'parametres'  => json_encode($request->except(['_token', 'code', 'nom', 'action', 'script_id'])),
                ]
            );

            return back()->with('success', "Script '" . $request->nom . "' sauvegardé avec succès !");
        }

        // --- ACTION : EXÉCUTER OU TESTER ---
        $request->validate([
            'connection_type' => 'required|in:mariadb,oracle_custom',
            'code' => 'required_unless:action,test_connection',
        ]);

        $query = $request->input('code'); // On récupère le contenu du script
        $type = $request->input('connection_type');

        // Config Oracle dynamique
        if ($type === 'oracle_custom') {
            $privilege = null;
            if ($request->input('ora_as') === 'SYSDBA') $privilege = OCI_SYSDBA;
            elseif ($request->input('ora_as') === 'SYSOPER') $privilege = OCI_SYSOPER;

            Config::set('database.connections.oracle_runtime', [
                'driver'   => 'oracle',
                'host'     => $request->input('ora_host'),
                'port'     => $request->input('ora_port', '1521'),
                'database' => $request->input('ora_db'),
                'username' => $request->input('ora_user'),
                'password' => $request->input('ora_pass'),
                'charset'  => 'AL32UTF8',
                'prefix'   => '',
                'options'  => ['privilege' => $privilege],
            ]);
            $connection = 'oracle_runtime';
        } else {
            $connection = 'mariadb';
        }

        try {
            // Test de connexion
            if ($request->input('action') === 'test_connection') {
                DB::connection($connection)->getPdo();
                return back()->with('success', "✅ Connexion réussie à $type !")->withInput();
            }

            // Exécution SQL (Sécurité)
            if (!str_starts_with(strtolower(trim($query)), 'select')) {
                throw new \Exception("Sécurité : Seuls les SELECT sont autorisés.");
            }

            $results = DB::connection($connection)->select($query);
            $data = collect($results)->map(fn($x) => (array) $x);
            $lineCount = $data->count();
            $headers = $data->isEmpty() ? [] : array_keys($data->first());
            $scripts = ScriptExtraction::orderBy('nom')->get();

            session()->flash('success', "✅ Extraction réussie ($lineCount lignes trouvées).");

            return view('extraction.index', [
                'scripts' => $scripts,
                'data' => $data,
                'headers' => $headers,
                'query' => $query,
                'type' => $type,
                'connection' => $connection,
                'lineCount' => $lineCount
            ]);

        } catch (\Exception $e) {
            return back()->withErrors(['sql_error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $script = ScriptExtraction::findOrFail($id);
        $script->delete();
        return back()->with('success', "Script supprimé.");
    }

    public function export(Request $request)
    {
        $query = $request->input('code'); // Utilise 'code' pour l'export
        $connection = $request->input('connection');
        $results = DB::connection($connection)->select($query);
        $data = collect($results)->map(fn($x) => (array) $x);

        return Excel::download(new DynamicQueryExport($data), 'extraction_' . date('Ymd_His') . '.xlsx');
    }
}
