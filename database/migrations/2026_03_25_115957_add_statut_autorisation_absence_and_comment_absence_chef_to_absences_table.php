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
        Schema::table('absences', function (Blueprint $table) {
            // Le statut avec vos 3 valeurs spécifiques
            $table->enum('statut_autorisation_absence', ['en_attente', 'valide_chef', 'rejete'])
                ->default('en_attente');

            // Le commentaire du chef (nullable car vide au départ)
            $table->text('comment_absence_chef')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropColumn(['statut_autorisation_absence', 'comment_absence_chef']);
        });
    }
};
