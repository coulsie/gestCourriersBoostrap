<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // On récupère les dates depuis le formulaire (ou par défaut la semaine en cours)
        $start = $request->input('start', now()->startOfWeek());
        $end = $request->input('end', now()->endOfWeek());

        // C'EST ICI QUE VOUS COPIEZ LA LOGIQUE :
        $synthese = Direction::with(['services.activities' => function($query) use ($start, $end) {
            $query->whereBetween('report_date', [$start, $end]);
        }])->get();

        // On envoie les données à la vue
        return view('reports.index', compact('synthese', 'start', 'end'));
    }
}
