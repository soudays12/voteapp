<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,DB;
use App\Models\{UserSession,Vote};

class VoteController extends Controller
{
    public function vote(Request $request, $session_id) 
    {

        $user = auth()->user();

        // Vérifier si l'utilisateur a déjà voté pour ce candidat
        $existingVote = UserSession::where('user_id', $user->id)
            ->where('session_id', $session_id)
            ->first();

        if ($existingVote) {
            // Gérer le cas où l'utilisateur a déjà voté
            return redirect()->back()->with('error', 'Désolé vous avez déja voté un candidat.');
        }else{
            // continuer le processus de vote
            
            // Enregistrer le vote
            // passons par une transaction pour enregistrer le vote et incrementer le nombre de vote du candidat
            DB::transaction(function () use ($session_id, $request,$user) 
            {
                

                // les tables concernés
                $vote = Vote::create([
                    'voting_id' => $request->voting_id,
                ]);

                $vote = UserSession::create([
                    'user_id' => $user->id,
                    'session_id' => $request->session_id,
                ]);
                 // les tables concernés


                $candidate_id = $request->candidate_id;


                DB::table('candidates')->where('id',$candidate_id)->increment('countvote');

                return redirect()->back()->with('success', 'Vote enregistré avec succès.');
            });
        }

    }
}
