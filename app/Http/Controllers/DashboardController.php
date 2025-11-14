<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Session,Candidate, User, Vote};
use App\Services\StatsService;

class DashboardController extends Controller
{
    public function __construct(
        private StatsService $statsService
    ) {}

    // ------------------    partie 1 -----------------
    // retournon les vues
    //la vue principale
    public function index(){
        $sessions = Session::count();
        $users = User::count();
        $candidats = Candidate::count();
        $votes = Vote::count(); // Compte les votes pour le candidat
        return view("dashboard.index", compact('users','candidats','votes','sessions'));
    }
    // la liste des sessions et leur gestion
    public function sessions(){
        $sessions = Session::all();
        return view('dashboard.sessions',compact('sessions'));
    }
    //la vue qui retourne tous les utilisateurs
    public function users(){
        $users = User::all();
        return view("dashboard.users",compact('users'));
    }
    //la vue qui retourne tous les candidates
    public function candidates(){
        $candidats = Candidate::all();
        $sessions = Session::all();
        
        // Calculer les pourcentages pour chaque candidat
        $candidatsWithPercentage = $candidats->map(function($candidat) {
            $candidat->percentage = $this->statsService->getCandidatePercentage($candidat);
            return $candidat;
        });
        
        return view("dashboard.candidates",compact('candidatsWithPercentage','sessions'));
    }
    //la vue election qui retourne les elections
    public function elections()
    {
        $candidats = Candidate::all();
        return view("dashboard.elections",compact('candidats'));
    }
    // resultats
    public function resultats()
    {
        $sessions = Session::all();
        return view('dashboard.results', compact('sessions'));
    }
    // resultats d'une session
    public function resultatSession($id)
    {
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

            return view('dashboard.resultatSession', compact('session', 'bestCandidate', 'topCandidates', 'candidats', 'tiedCandidates'));

        } catch (\Exception $e) {
            \Log::error('Erreur resultofsession: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du calcul des résultats: ' . $e->getMessage());
        }
    }
    
    
    
    
    // ------------------    partie 3 -----------------
    //petit crud laravel
  
    // action de l'enregistrement d'un post
    public function store(Request $request)
    {
        $request->validate([
        'title' => 'required|max:255',
        'body' => 'required',
        ]);
        Post::create($request->all());
        return redirect()->route('posts.index')
        ->with('success', 'Post created successfully.');
    }
    

    // action de mise à jour d'un post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $post = Post::find($id);
        $post->update($request->all());
        return redirect()->route('posts.index')
        ->with('success', 'Post updated successfully.');
    }

    // action de suppression d'un post
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index')
        ->with('success', 'Post deleted successfully');
    }
   
    // retourne la vue de cration
    public function create()
    {
        return view('posts.create');
    }
    
    // retourne la vue de avec les donnees
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }
   
    // retourne la vue de modification
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }
    //fin du petit crud laravel
    // fin du petit crud laravel
}
