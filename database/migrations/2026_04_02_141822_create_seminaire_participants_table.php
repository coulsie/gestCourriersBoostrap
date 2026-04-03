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
        Schema::create('seminaire_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminaire_id')->constrained()->onDelete('cascade');

            // Pour l'interne : liaison avec votre table 'agents'
            $table->foreignId('agent_id')->nullable()->constrained('agents');

            // Pour l'externe : informations directes
            $table->string('nom_externe')->nullable();
            $table->string('organisme_externe')->nullable();

            // Émargement (Liste de présence)
            $table->boolean('est_present')->default(false);
            $table->dateTime('heure_pointage')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminaire_participants');
    }
};
