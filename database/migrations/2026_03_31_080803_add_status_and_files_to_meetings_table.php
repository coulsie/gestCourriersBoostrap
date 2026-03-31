<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('meetings', function (Blueprint $table) {
        $table->string('status')->default('programmee'); // programmee, terminee, annulee
        $table->string('presence_file')->nullable(); // Chemin du scan
        $table->string('report_file')->nullable();   // Chemin du compte-rendu
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            //
        });
    }
};
