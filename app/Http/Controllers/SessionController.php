<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Carbon\Carbon;

class SessionController extends Controller
{
    // Affiche le formulaire d’ajout
    public function addSession()
    { 
        
        return view('dashboard.add.addSession');  
    }

    // Affiche les détails d’une session
    public function detailSession($session_id)
    {
        $session = Session::find($session_id);
        return view('dashboard.detail.detailSession', compact('session'));  
    }

    // Affiche la vue de modification
    public function editSession($session_id)
    {
        $session= Session::find($session_id);
        return view('dashboard.edit.editSession', compact('session'));
    }


    // Crée une session et ses candidats
    public function store(Request $request)
    {
        // 🔹 1. Validation des champs envoyés depuis ton formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date_fin' => 'nullable|date',
        ]);

        $now = Carbon::now();

        // 🔹 2. Gestion de la case "Démarrer maintenant"
        // Si cochée => on démarre tout de suite
        if ($request->has('demarrer')) {
            $date_debut = $now;
        } else {
            // Sinon on prend la date fournie ou on met aujourd’hui par défaut
            $date_debut = isset($validated['date_debut']) ? Carbon::parse($validated['date_debut']) : $now;
        }

        // 🔹 3. Gestion de la date de fin
        $date_fin = isset($validated['date_fin']) ? Carbon::parse($validated['date_fin']) : null;

        // 🔹 4. Vérifications logiques simples et cohérentes
        // (a) Si la date de début est dans le passé (et pas démarrer maintenant)
        if (!$request->has('demarrer') && $date_debut->lt($now)) {
            return redirect()->back()->withInput()->with('error', 'La date de début ne peut pas être antérieure à la date actuelle.');
        }

        // (b) Si la date de fin est avant aujourd’hui
        if ($date_fin && $date_fin->lt($now)) {
            return redirect()->back()->withInput()->with('error', 'La date de fin ne peut pas être antérieure à la date actuelle.');
        }

        // (c) Si la date de fin est avant la date de début
        if ($date_fin && $date_fin->lt($date_debut)) {
            return redirect()->back()->withInput()->with('error', 'La date de fin ne peut pas être antérieure à la date de début.');
        }

        // 🔹 5. Création de la session
        $session = Session::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
        ]);

        return redirect()->back()->with('success', 'Session enregistrée avec succès !');
    }

    

    // Crée une session et ses candidats 
    /*
    public function store(Request $request)
    {
        if(isset($request->date_fin) && $request->date_fin < now()){
            if(isset($request->date_debut) && $request->date_debut < now()){
                if($request->date_debut < $request->date_fin){
                    return redirect()->back()->withErrors(['date_debut' => 'La date de début ne peut pas être antérieure à la date de fin.'])->withInput();

                }

                return redirect()->back()->withErrors(['date_debut' => 'La date de début ne peut pas être antérieure à la date actuelle.'])->withInput();
            }else{
                if(!isset($request->date_debut)){
                    return redirect()->back()->withErrors(['date_fin' => 'La date de fin ne peut pas être antérieure à la date actuelle.'])->withInput();
                }
            }

            return redirect()->back()->withErrors(['date_fin' => 'La date de fin ne peut pas être antérieure à la date actuelle.'])->withInput();
        }
        if($request->date_debut == null){
            $date_debut = now();
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'candidats' => 'required|string',
        ]);
    
        // 1️⃣ Créer la session
        $session = Session::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
        ]);
    
        // 2️⃣ Enregistrer les candidats associés
        /*
        $candidats = json_decode($validated['candidats'], true);
        foreach ($candidats as $candidat) {
            Candidate::create([
                'session_id' => $session->id,
                'nom' => $candidat['nom'],
                'description' => $candidat['description'],
                // tu peux gérer l'image ici plus tard si tu veux
            ]);
        }
        

        return redirect()->back()->with('success', 'Session et candidats enregistrés avec succès !');
    }
    */


    // Met à jour une session
    public function updateSession(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
        ]);
        $now = Carbon::now();

        
        // 🔹 3. Gestion de la date de debut et de fin
        $date_debut = isset($validated['date_debut']) ? Carbon::parse($validated['date_debut']) : $now;
        $date_fin = isset($validated['date_fin']) ? Carbon::parse($validated['date_fin']) : null;

        
        // (b) Si la date de fin est avant aujourd’hui
        if ($date_fin && $date_fin->lt($now)) {
            return redirect()->back()->withInput()->with('error', 'La date de fin ne peut pas être antérieure à la date actuelle.');
        }

        // (c) Si la date de fin est avant la date de début
        if ($date_fin && $date_fin->lt($date_debut)) {
            return redirect()->back()->withInput()->with('error', 'La date de fin ne peut pas être antérieure à la date de début.');
        }


        $id = $request->id;
        $session = Session::find($id);
        $session->update($request->all());

        return redirect()->route('dashboard.sessions')
                         ->with('success', 'Session mise à jour avec succès.');
    }

    // Supprime une session
    public function deleteSession(Request $request, $session_id)
    {
        $session = Session::find($session_id);
        $session->delete($request->all());

        return redirect()->route('dashboard.sessions')
                         ->with('success', 'Session supprimée avec succès.');
    }
}





