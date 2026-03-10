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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('event');        // ex: 'created', 'updated', 'deleted', 'login', 'viewed'
            $table->string('auditable_type'); // ex: 'App\Models\Courrier' ou 'App\Models\Agent'
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('old_values')->nullable(); // Valeurs avant modification
            $table->json('new_values')->nullable(); // Valeurs après modification
            $table->string('url')->nullable();      // Page où l'action a eu lieu
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable(); // Navigateur utilisé
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
