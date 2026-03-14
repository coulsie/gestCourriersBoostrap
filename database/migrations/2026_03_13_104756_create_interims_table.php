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
                
            Schema::create('interims', function (Blueprint $table) {
            $table->id();
            // Les références administratives (Table Agents)
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            $table->foreignId('interimaire_id')->constrained('agents')->onDelete('cascade');

            // Le lien direct vers l'utilisateur connecté pour faciliter Auth::user()
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('motif')->nullable(); // Ex: Congés annuels, Mission...
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interims');
    }
};
