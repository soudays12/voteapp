<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('taille');
            $table->string('format');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade'); // Utiliser candidate_id au lieu de candidate_uuid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};