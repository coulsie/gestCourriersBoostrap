<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du jour férié (ex: Noël)
            $table->date('holiday_date')->unique(); // Date unique pour éviter les doublons
            $table->text('description')->nullable(); // Optionnel
            $table->boolean('is_recurring')->default(false); // Si la date est fixe chaque année
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
