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
        Schema::create('seminaire_emargements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminaire_id')->constrained()->onDelete('cascade');
            $table->foreignId('participant_id')->constrained('seminaire_participants')->onDelete('cascade');
            $table->date('date_pointage'); // Le jour concerné
            $table->datetime('heure_pointage')->nullable();
            $table->boolean('est_present')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminaire_emargements');
    }
};
