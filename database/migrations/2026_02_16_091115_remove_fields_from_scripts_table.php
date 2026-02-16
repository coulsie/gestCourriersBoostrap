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
    Schema::table('scripts_extraction', function (Blueprint $table) {
        $table->dropColumn([
            'type_entreprise',
            'type_impot',
            'type_contribuable',
            'date_debut',
            'date_fin'
        ]);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scripts_extraction', function (Blueprint $table) {
           $table->string('type_entreprise')->nullable();
            $table->string('type_impot')->nullable();
            $table->string('type_contribuable')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
        });
    }
};
