<?php

namespace App\Services;

use App\Models\Session;
use App\Models\Candidate;

class StatsService
{
    public function calculatePercentage(Candidate $candidate): float
    {
        // Récupère tous les candidats de la même session
        $candidats = $candidate->session->candidates;

        // Calcule le total des votes pour la session
        $total_votes_session = 0;
        foreach ($candidats as $cand) {
            $total_votes_session += $candidate->votes()->count();
        }

        // Votes pour ce candidat
        $candidate_votes = $candidate->votes()->count();

        if ($total_votes_session === 0) {
            return 0;
        }

        return round(($candidate_votes * 100) / $total_votes_session, 2);
    }

    // Autres méthodes statistiques...
    public function getSessionStats(Session $session): array
    {
        // Implémentation...
    }
}