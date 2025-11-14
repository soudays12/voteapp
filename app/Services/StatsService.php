<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Vote;

class StatsService
{
    public function getCandidatePercentage(Candidate $candidate): float
    {
        if (!$candidate->session_id) {
            return 0.0;
        }

        // Compte total des votes pour tous les candidats de la session
        $totalVotes = Vote::whereHas('candidate', function ($query) use ($candidate) {
            $query->where('session_id', $candidate->session_id);
        })->count();

        if ($totalVotes === 0) {
            return 0.0;
        }

        // Votes pour ce candidat
        $candidateVotes = $candidate->vote()->count();

        return round(($candidateVotes * 100) / $totalVotes, 2);
    }

    public function getSessionStats(int $sessionId): array
    {
        $candidates = Candidate::where('session_id', $sessionId)
            ->withCount('vote')
            ->get();

        $totalVotes = $candidates->sum('vote_count');

        return $candidates->map(function ($candidate) use ($totalVotes) {
            return [
                'candidate_id' => $candidate->id,
                'nom' => $candidate->nom,
                'votes' => $candidate->vote_count,
                'percentage' => $totalVotes > 0 ? round(($candidate->vote_count * 100) / $totalVotes, 2) : 0.0
            ];
        })->toArray();
    }
}