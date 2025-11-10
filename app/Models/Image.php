<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "taille", 
        "format",
        "candidate_id", // Changer pour candidate_id
    ];
    
    public function candidate()
    {
        return $this->belongsTo(Candidate::class); // Relation standard
    }
}