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
        Schema::create('point_data', function (Blueprint $table) {
            $table->id();
            $table->string('assessment')->nullable();
            $table->string('old_assessment')->nullable();
            $table->string('Floor')->nullable();
            $table->string('bill_usage')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('ration_no')->nullable();
            $table->string('phone_numnber')->nullable();
            $table->string('shop_floor')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_owner_name')->nullable();
            $table->string('shop_category')->nullable();
            $table->string('shop_mobile')->nullable();
            $table->string('license')->nullable();
            $table->string('professional_tax')->nullable();
            $table->string('gst')->nullable();
            $table->string('number_of_emplyee')->nullable();
            $table->string('trade_income')->nullable();
            $table->string('establishment_remarks')->nullable();
            $table->foreignId('gisid')->constrained('building_data')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_data');
    }
};