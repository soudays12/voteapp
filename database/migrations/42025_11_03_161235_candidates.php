<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('voting_id')->unique();
            $table->string('nom')->unique();
            $table->string('description')->unique();
            $table->string('photo')->default('avatar.jpg');
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
            $table->integer('countvote')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
