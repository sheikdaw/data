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
        Schema::create('building_data', function (Blueprint $table) {
            $table->id();
            $table->string('gisid');
            $table->string('number_bill');
            $table->string('number_floor');
            $table->string('watet_tax');
            $table->string('new_address');
            $table->string('liftroom');
            $table->string('headroom');
            $table->string('overhead_tank');
            $table->string('percentage');
            $table->string('eb');
            $table->string('building_name');
            $table->string('building_usage');
            $table->string('construction_type');
            $table->string('road_name');
            $table->string('ugd');
            $table->string('rainwater_harvesting');
            $table->string('parking');
            $table->string('ramp');
            $table->string('hoarding');
            $table->string('cell_tower');
            $table->string('solar_panel');
            $table->string('basement');
            $table->string('water_connection');
            $table->string('phone');
            $table->string('building_type');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_data');
    }
};
