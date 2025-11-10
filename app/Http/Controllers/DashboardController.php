<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Session,Candidate, User, Vote};

class DashboardController extends Controller
{

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
        return view("dashboard.candidates",compact('candidats','sessions'));
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

    // resultats
  
    public function resultatSession(Session $session)
    {

        return view('dashboard.resultSession', compact('session'));
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
