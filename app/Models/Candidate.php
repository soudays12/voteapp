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
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $uuid = (string) Str::uuid();
            
            if ($model->session_id) {
                $model->voting_id = 'S' . $model->session_id . '-' . substr(str_replace('-', '', $uuid), 0, 12);
            } else {
                $model->voting_id = $uuid;
            }
        });
    }

    public function session(){
        return $this->belongsTo(Session::class);
    }
    
    public function vote(){
        return $this->hasMany(Vote::class, 'voting_id', 'voting_id');
    }
    
    public function image()
    {
        return $this->hasMany(Image::class); // Relation standard
    }
}