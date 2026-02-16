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
        $table->longText('code')->nullable(); // Contiendra le script SQL
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scripts_extraction', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
