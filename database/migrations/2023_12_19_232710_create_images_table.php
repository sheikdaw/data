<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('gisid'); // Adjust to the actual type of gisid
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('gisid')->references('gisid')->on('surveyed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
