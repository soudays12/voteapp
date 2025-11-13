<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        "voting_id",
        "nom",
        "description", 
        "photo",
        "session_id",
        "countvote",
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Try to include the session id in the voting id for easier grouping/inspection
            // If session_id is not set yet, fall back to a plain UUID.
            $sessionId = $model->session_id ?? ($model->session?->id ?? null);

            // Generate a UUID
            $uuid = (string) Str::uuid();

            if ($sessionId) {
                // Format: S<sessionId>-<short-uuid> (shortened for readability)
                $model->voting_id = 'S' . $sessionId . '-' . substr(str_replace('-', '', $uuid), 0, 12);
            } else {
                // Full uuid fallback
                $model->voting_id = $uuid;
            }
        });
    }

    public function session(){
        return $this->belongsTo(Session::class);
    }
    
    public function vote(){
        return $this->hasMany(Vote::class,'voting_id');
    }
    
    public function image()
    {
        return $this->hasMany(Image::class); // Relation standard
    }

    
}   