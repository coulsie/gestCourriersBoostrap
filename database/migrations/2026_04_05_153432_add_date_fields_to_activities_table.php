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
        Schema::table('activities', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('service_id');
            $table->date('end_date')->nullable()->after('start_date');
            $table->boolean('is_permanent')->default(false)->after('end_date');
            // 'report_date' peut devenir la date de mise à jour effective du rapport
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
};
