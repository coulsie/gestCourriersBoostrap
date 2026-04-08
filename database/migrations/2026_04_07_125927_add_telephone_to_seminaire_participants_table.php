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
        Schema::table('seminaire_participants', function (Blueprint $table) {
            // On ajoute d'abord l'email
            $table->string('email')->nullable(); // ou après une autre colonne existante

            // Puis le téléphone après l'email
            $table->string('telephone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('seminaire_participants', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }
};
