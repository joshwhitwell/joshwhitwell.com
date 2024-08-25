<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('source_title')->nullable();
            $table->string('section_title')->nullable();
            $table->string('publication_year')->nullable();
            $table->string('publication_month')->nullable();
            $table->string('publication_day')->nullable();
            $table->string('publisher')->nullable();
            $table->string('publisher_place')->nullable();
            $table->text('contributors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
