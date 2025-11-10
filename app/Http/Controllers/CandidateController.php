<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Storage};
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\{Candidate, Image, Vote};

class CandidateController extends Controller
{

    //on enregistre un candidat


    public function store(Request $request)
    {
        try {
            // 1️⃣ Validation des données
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'session_id' => 'required|exists:sessions,id'

            ]);

            // 2️⃣ Transaction : on fait tout ou rien
            DB::transaction(function () use ($request) {
                // 📁 Récupération du fichier envoyé
                $file = $request->file('image');

                // 📄 Infos du fichier
                $nomOriginal = $file->getClientOriginalName();
                $taille = $file->getSize();
                $extension = $file->getClientOriginalExtension();

                // 🔠 Nom unique pour le stockage
                $nomFichier = time() . '_' . uniqid() . '.' . $extension;

                // 📦 Déplacement du fichier vers public/images
                $file->move(public_path('images'), $nomFichier);

                // 🧍 Créer et sauvegarder le candidat
                $candidate = Candidate::create([
                    'nom' => $request->nom,
                    'description' => $request->description,
                    'photo' => $nomFichier,
                    'session_id' => $request->session_id,
                ]);

                // 🖼️ Créer l'image liée
                Image::create([
                    'nom' => $nomOriginal,
                    'taille' => $taille,
                    'format' => $extension,
                    'candidate_id' => $candidate->id,
                ]);
            });

            // ✅ Succès
            return redirect()->back()->with('success', 'Candidat ajouté avec succès !');

        } catch (ValidationException $e) {
            // ❌ Erreur de validation
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Erreur de validation des données.' . $e->getMessage());

        } catch (QueryException $e) {
            // ❌ Erreur de base de données
            \Log::error('Erreur DB lors de la création du candidat: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur de base de données lors de la création du candidat.' . $e->getMessage());

        } catch (Exception $e) {
            // ❌ Erreur générale
            \Log::error('Erreur générale lors de la création du candidat: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.' . $e->getMessage());
        }
    }

   




    // ------------------    partie 2 -----------------
    // partie crud

    // les details des ressources
    public function detailCandidate($candidate_id){
        $candidate_info = Candidate::find($candidate_id);
        return view('detail.detailCandidate', compact('candidate_info'));
    }
    public function editCandidates($candidate_id)
    {
        $candidate_info = Candidate::find($candidate_id);
        return view('edit.updateCandidate', compact('candidate_info'));
    }
    
    // retourne les fonctions de mise à jour
    public function updateCandidate(Request $request,$candidate_id){
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $post = Candidate::find($candidate_id);
        $post->update($request->all());
        return redirect()->route('posts.index')
        ->with('success', 'Post updated successfully.');
    }

    // action de suppression d'un post
    public function deleteCandidate($candidate_d)
    {
        $candidate = Candidate::find($candidate_d);
        $candidate->delete();
        return redirect()->route('dashboard.candidates')->with('success', 'Informations du candidat modifiés avec succès !');
    }











    // mise à jour du candidat
    public function update(Request $request, $id)
    {
        $request->validate([
            'uuid' => 'required',
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'required|string|photo|max:255|unique:candidte',
        ]);
        $candidate = Candidate::find($id);
        $candidate->update($request->all());
        return redirect()->back()->with('success', 'Candidat modifié avec succès');
    }
 
    // suppression du candidat
    public function destroy($id)
    {
        $candidate = Candidate::find($id);
        $candidate->delete();
        return redirect()->back()->with('success', 'Candidat supprimé avec succès');
    }
    


    // compter le nombre de vote du candidat
    public function voteCount($candidate_id)
    {
        $candidat = Candidat::find($candidat_id);
        $voteCount = Vote::where('candidate_id', $candidat_id)->count(); // Compte les votes pour le candidat

        return $VoteCount;
    }
 
    // calculer le pourcentage de reussite d'un candidat
    public function percentage($candidate_id)
    {
        $total_candidats = Candidate::count();
        $total_votes = Vote::count(); // Supprimer where('user_id')
        $pourcentage = ($total_votes * 100) / max($total_candidats, 1); // Éviter division par zéro
        
        return $pourcentage;
    }





    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }
}