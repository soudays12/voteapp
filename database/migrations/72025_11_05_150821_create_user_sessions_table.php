<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id(); // clé primaire auto-incrémentée
        
            // user_id en entier
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
            // session_id en entier pour correspondre à sessions.id
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
        
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
        
    }
    
    /**
     * Reverse the migrations.
     */
};
