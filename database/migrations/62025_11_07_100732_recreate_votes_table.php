<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Supprimer l'ancienne table si elle existe
        Schema::dropIfExists('votes');

        // Créer la table à nouveau
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->uuid('voting_id');
            $table->foreign('voting_id')
                  ->references('voting_id')
                  ->on('candidates')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
