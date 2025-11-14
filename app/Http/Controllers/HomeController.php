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
        $percentage = $this->statsService->getCandidatePercentage($candidate);
        
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
        $session = Session::with('candidates')->findOrFail($id);
        
        // Calculer les pourcentages pour chaque candidat
        $session->candidates->each(function($candidat) {
            $candidat->percentage = $this->statsService->getCandidatePercentage($candidat);
            // Debug temporaire
            $candidat->debug_votes = $candidat->vote()->count();
        });
        
        return view('sessionitem', compact('session'));
    }

    // resultats
    public function results()
    {
        $sessions = Session::all();
        return view('results', compact('sessions'));
    }


    public function resultofsession($id){
        try {
            $session = Session::with('candidates')->findOrFail($id);

            // Calculer les statistiques pour tous les candidats
            $candidats = $session->candidates->map(function($candidate) {
                $candidate->votes_count = $candidate->vote()->count();
                $candidate->percentage = $this->statsService->getCandidatePercentage($candidate);
                return $candidate;
            })->sortByDesc(function($candidate) {
                // Tri par votes_count puis par created_at (le plus ancien gagne en cas d'égalité)
                return [$candidate->votes_count, -$candidate->created_at->timestamp];
            });

            // Vérifier s'il y a égalité pour le meilleur candidat
            $maxVotes = $candidats->first()->votes_count ?? 0;
            $winners = $candidats->filter(function($candidate) use ($maxVotes) {
                return $candidate->votes_count === $maxVotes;
            });

            $bestCandidate = $winners->count() > 1 ? null : $candidats->first();
            $tiedCandidates = $winners->count() > 1 ? $winners : collect();

            // Top 3 candidats
            $topCandidates = $candidats->take(3);

            return view('resultofsession', compact('session', 'bestCandidate', 'topCandidates', 'candidats', 'tiedCandidates'));

        } catch (\Exception $e) {
            \Log::error('Erreur resultofsession: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du calcul des résultats: ' . $e->getMessage());
        }
    }




   
}
