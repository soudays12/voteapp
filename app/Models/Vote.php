<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User, Candidate};

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        "voting_id",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class, 'voting_id', 'voting_id');
    }
}
