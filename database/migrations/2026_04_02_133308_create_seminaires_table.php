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
        Schema::create('seminaires', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('lieu');
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('organisateur');

            // Changement ici : string au lieu d'enum pour accepter "en attente du rapport final"
            $table->string('statut')->default('planifie');

            $table->integer('nb_participants_prevu')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminaires');
    }
};
