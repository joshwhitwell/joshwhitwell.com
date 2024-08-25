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
            $table->text('body')->nullable();
            $table->string('publisher_year')->nullable();
            $table->string('publisher_name')->nullable();
            $table->string('publisher_location')->nullable();
            $table->string('pages')->nullable();
            $table->text('contributors')->nullable();
            $table->integer('visibility')->default(1);
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
