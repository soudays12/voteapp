<?php

namespace App\Http\Controllers;
use App\Services\StatsService;
use App\Models\{Candidate,Session};

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private StatsService $statsService
    ) {}

    public function show(Candidate $candidate)
    {
        $percentage = $this->statsService->calculatePercentage($candidate);
        
        return view('candidate.show', [
            'candidate' => $candidate,
            'percentage' => $percentage
        ]);
    }


    public function index()
    {
        $candidats = Candidate::all();
        $sessions = Session::all();
        return view('welcome', compact('candidats','sessions'));
    }


    // elections 
    public function elections()
    {
        $candidats = Candidate::all();
        $sessions = Session::all();
        return view('elections', compact('candidats','sessions'));
    }
    // detail session
    public function sessionitem($id)
    {
        // Charger la session avec les candidats liés
        $session = Session::with([
            'candidates' => function ($query) {
                $query->withCount('vote'); // Compte les votes pour chaque candidat
            }
        ])->findOrFail($id);  
        //dd($session);      
        return view('sessionitem', compact('session'));
    }

    // resultats
    public function results()
    {
        $sessions = Session::all();
        return view('results', compact('sessions'));
    }


    public function resultofsession(Request $request){
         try {
            $session_id = $request-> $id;

            // Récupère le candidat avec le plus de votes
            $candidates = Candidate::count('votes')
                ->orderBy('votes_count', 'DESC')
                ->where('session_id', $session_id)
                ->first();

            // Ou les top 3 candidats
            $topCandidates = Candidate::count('votes')
                ->orderBy('votes_count', 'DESC')
                ->where('session_id', $session_id)
                ->take(3)
                ->get();

            // Tous les candidats avec leur nombre de votes pour affichage
            $allCandidates = Candidate::count('votes')
                ->orderBy('votes_count', 'DESC')
                ->where('session_id', $session_id)
                ->get();

            return view('resultofsession', [
                'bestCandidate' => $bestCandidate,
                'topCandidates' => $topCandidates,
                'allCandidates' => $allCandidates
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur bestCandidate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du calcul des résultats'. $e->getMessage());
        }
    }




   
}
