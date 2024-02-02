<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\surveyed;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('gisid'); // Adjust to the actual type of gisid
            $table->timestamps();
        });
    }
    public function surveyed()
    {
        return $this->belongsTo(Surveyed::class, 'gisid', 'gisid');
    }
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
