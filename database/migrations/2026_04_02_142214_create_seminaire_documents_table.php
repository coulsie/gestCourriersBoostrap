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
       Schema::create('seminaire_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminaire_id')->constrained();
            $table->string('nom_document'); // ex: "Liste d'émargement", "Rapport final"
            $table->string('fichier_path');
            $table->enum('type', ['presence', 'rapport', 'support']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminaire_documents', function (Blueprint $table) {
            //
        });
    }
};
