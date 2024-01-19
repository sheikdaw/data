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
        Schema::create('mis', function (Blueprint $table) {
            $table->id();
            $table->string('assessment')->nullable();
            $table->string('ward')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('present_owner')->nullable();
            $table->string('water_tax')->nullable();
            $table->string('building_location')->nullable();
            $table->string('mobile')->nullable();
            $table->string('gisid')->nullable();
            $table->string('build_uparea')->nullable();
            $table->string('building_name')->nullable();
            $table->string('old_assessment')->nullable();
            $table->string('building_structure')->nullable();
            $table->string('building_usage')->nullable();
            $table->string('building_type')->nullable();
            $table->string('ration')->nullable();
            $table->string('aadhar')->nullable();
            $table->string('number_of_shop')->nullable();
            $table->string('number_of_bill')->nullable();
            $table->string('number_of_floor')->nullable();
            $table->string('road_name')->nullable();
            $table->string('old_door_number')->nullable();
            $table->string('new_door_number')->nullable();
            $table->string('old_address')->nullable();
            $table->string('new_address')->nullable();
            $table->string('floor')->nullable();
            $table->string('construction_type')->nullable();
            $table->string('percentage')->nullable();
            $table->string('occupied')->nullable();
            $table->string('floor_usage')->nullable();
            $table->string('remarks')->nullable();
            $table->string('shop_floor')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_category')->nullable();
            $table->string('shop_mobile')->nullable();
            $table->string('shop_owner_name')->nullable();
            $table->string('license')->nullable();
            $table->string('professional_tax')->nullable();
            $table->string('establishment_remarks')->nullable();
            $table->string('number_of_employee')->nullable();
            $table->string('cctv')->nullable();
            $table->string('head_room')->nullable();
            $table->string('parking')->nullable();
            $table->string('hoading')->nullable();
            $table->string('ramp')->nullable();
            $table->string('basement')->nullable();
            $table->string('solar_panel')->nullable();
            $table->string('water_connection')->nullable();
            $table->string('over_headtank')->nullable();
            $table->string('lift_room')->nullable();
            $table->string('cellphone_tower')->nullable();
            $table->string('eb_connection')->nullable();
            $table->string('ugd')->nullable();
            $table->string('workername')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mis');
    }
};
