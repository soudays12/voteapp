<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Storage};
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\{Candidate, Image, Vote,Session};
use App\Services\StatsService;

class CandidateController extends Controller
{

    public function __construct(
        private StatsService $statsService
    ) {}


    public function detailCandidate($candidat_id)
    {
        $candidate = Candidate::with('session')->where('id',$candidat_id)->first();
        $percentage = $this->statsService->getCandidatePercentage($candidate);
        
        return view('dashboard.detail.detailCandidate', compact('candidate','percentage'));
    }


    
    
    // ------------------    partie 2 -----------------
    // partie crud
    
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
    // les details des ressources
    public function editCandidate($candidate_id)
    {
        $candidate_info = Candidate::find($candidate_id);
        $sessions = Session::all();
        return view('dashboard.edit.editCandidate', compact('candidate_info', 'sessions'));
    }

    // action de suppression d'un post
    public function deleteCandidate($candidate_d)
    {
        $candidate = Candidate::find($candidate_d);
        $candidate->delete();
        return redirect()->route('dashboard.candidates')->with('success', 'Informations du candidat modifiés avec succès !');
    }

    // mise à jour du candidat
    public function update(Request $request, $candidat_id)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'session_id' => 'required|exists:sessions,id'
            ]);

            DB::transaction(function () use ($request, $candidat_id) {
                $candidate = Candidate::findOrFail($candidat_id);
                $oldPhoto = $candidate->photo;

                // Si une nouvelle image est uploadée
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $nomOriginal = $file->getClientOriginalName();
                    $taille = $file->getSize();
                    $extension = $file->getClientOriginalExtension();
                    $nomFichier = time() . '_' . uniqid() . '.' . $extension;

                    // Supprimer l'ancienne photo
                    if ($oldPhoto && file_exists(public_path('images/' . $oldPhoto))) {
                        unlink(public_path('images/' . $oldPhoto));
                    }

                    // Déplacer la nouvelle photo
                    $file->move(public_path('images'), $nomFichier);

                    // Mettre à jour le candidat avec la nouvelle photo
                    $candidate->update([
                        'nom' => $request->nom,
                        'description' => $request->description,
                        'photo' => $nomFichier,
                        'session_id' => $request->session_id,
                    ]);

                    // Mettre à jour ou créer l'enregistrement Image
                    $candidate->image()->updateOrCreate(
                        ['candidate_id' => $candidate->id],
                        [
                            'nom' => $nomOriginal,
                            'taille' => $taille,
                            'format' => $extension,
                        ]
                    );
                } else {
                    // Mise à jour sans changer la photo
                    $candidate->update([
                        'nom' => $request->nom,
                        'description' => $request->description,
                        'session_id' => $request->session_id,
                    ]);
                }
            });

            return redirect()->route('dashboard.candidates')->with('success', 'Candidat modifié avec succès');

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Erreur de validation: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du candidat: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
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


    // retourne la vue de edition
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }



}