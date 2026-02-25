<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Reponse;
use Illuminate\Http\Request;
use App\Models\Imputation;
use Illuminate\Support\Facades\DB;   // Résout "Undefined DB"

use App\Models\User;


class ReponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
{
    $request->validate([
        'imputation_id' => 'required|exists:imputations,id',
        'contenu' => 'required|string',
        'pourcentage_avancement' => 'required|integer',
        'fichiers.*' => 'nullable|file'
    ]);

    $filePaths = [];
    if ($request->hasFile('fichiers')) {
        foreach ($request->file('fichiers') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('reponses'), $fileName);
            $filePaths[] = $fileName;
        }
    }

    // 1. Enregistrement de la réponse de l'agent actuel
    $reponse = new Reponse();
    $reponse->imputation_id = $request->imputation_id;
    $reponse->agent_id = auth::user()->agent->id;
    $reponse->contenu = $request->contenu;
    $reponse->fichiers_joints = $filePaths;
    $reponse->date_reponse = now();
    $reponse->pourcentage_avancement = $request->pourcentage_avancement;
    $reponse->save();

    // 2. Mise à jour de l'imputation parente (celle de l'agent actuel)
    $imputation = Imputation::findOrFail($request->imputation_id);
    $imputation->statut = ($request->pourcentage_avancement == 100) ? 'termine' : 'en_cours';
    $imputation->save();

    // 3. LOGIQUE DE FERMETURE GROUPÉE
    // Si l'avancement est à 100%, on ferme toutes les autres imputations du même courrier
    if ($request->pourcentage_avancement == 100) {
        Imputation::where('courrier_id', $imputation->courrier_id)
            ->where('id', '!=', $imputation->id) // On exclut l'imputation actuelle déjà traitée
            ->update([
                'statut' => 'termine',
                // Optionnel : on peut ajouter une note dans les instructions
                // 'instructions' => DB::raw("CONCAT(instructions, ' (Clôturé par finalisation collective)')")
            ]);
    }

    return redirect()->route('imputations.show', $request->imputation_id)
                     ->with('success', 'Réponse enregistrée. ' . ($request->pourcentage_avancement == 100 ? 'Le dossier a été clôturé pour tous les intervenants.' : ''));
}





public function valider(Request $request, $id)
{
    // 1. Récupération de la réponse
    $reponse = \App\Models\Reponse::findOrFail($id);

    // 2. Validation du fichier
    $request->validate([
        'document_final' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png|max:819200',
    ]);

    if ($request->hasFile('document_final')) {

        return DB::transaction(function () use ($request, $reponse) {
            $file = $request->file('document_final');

            // 3. Gestion du fichier
            $fileName = time() . '_FINAL_' . $file->getClientOriginalName();
            $file->move(public_path('archives/final'), $fileName);

            // 4. Mise à jour de la réponse
            $reponse->validation = 'acceptee';
            $reponse->document_final_signe = 'archives/final/' . $fileName;
            $reponse->date_approbation = now();
            $reponse->save();

            // 5. Mise à jour de l'Imputation parente et clôture de TOUTES les imputations liées
            if ($reponse->imputation_id) {
                $imputationSource = \App\Models\Imputation::find($reponse->imputation_id);

                if ($imputationSource) {
                    // On clôture TOUTES les imputations qui concernent le même courrier
                    \App\Models\Imputation::where('courrier_id', $imputationSource->courrier_id)
                        ->update(['statut' => 'termine']);

                    // 6. Mise à jour du Courrier lié en "archivé"
                    if ($imputationSource->courrier_id) {
                        $courrier = \App\Models\Courrier::find($imputationSource->courrier_id);
                        if ($courrier) {
                            $courrier->statut = 'archivé';
                            $courrier->save();
                        }
                    }
                }
            }

            return back()->with('success', 'Dossier validé. Le courrier a été archivé et clôturé pour l\'ensemble des intervenants.');
        });
    }

    return back()->with('error', 'Échec de la validation : fichier manquant.');
}


    public function show(Reponse $reponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reponse $reponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reponse $reponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reponse $reponse)
    {
        //
    }
}
