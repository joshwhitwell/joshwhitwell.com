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
        Schema::table('lift_sets', function (Blueprint $table) {
            $table->string('percent_one_rep_max')->nullable()->after('intensity_technique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lift_sets', function (Blueprint $table) {
            $table->dropColumn('percent_one_rep_max');
        });
    }
};
