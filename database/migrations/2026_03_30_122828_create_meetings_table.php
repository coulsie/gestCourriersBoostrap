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
       Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('objet');
            $table->dateTime('date_heure'); // Date et heure de début
            $table->integer('duree_minutes')->default(60);
            $table->string('lieu')->default('Abidjan');
            // Les rôles (liés à votre table agents ou users)
            $table->foreignId('animateur_id')->constrained('agents');
            $table->foreignId('redacteur_id')->constrained('agents');

            $table->text('ordre_du_jour')->nullable();
            $table->timestamps();
        });

        // Table pivot pour les participants (Plusieurs agents par réunion)
        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('agents');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
