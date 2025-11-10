<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

      protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
    ];
        

    public function candidates(){
        return $this->hasMany(Candidate::class);
    }

    public function userSessions(){
        return $this->hasMany(UserSession::class);
    }
}
