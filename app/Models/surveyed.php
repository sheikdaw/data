<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surveyed extends Model
{
    use HasFactory;
    protected $fillable = [
        'assessment',
        'ward',
        'owner_name',
        'present_owner',
        'water_tax',
        'building_location',
        'mobile',
        'gisid',
        'build_uparea',
        'building_name',
        'old_assessment',
        'building_structure',
        'building_usage',
        'building_type',
        'ration',
        'aadhar',
        'number_of_shop',
        'number_of_bill',
        'number_of_floor',
        'road_name',
        'old_door_number',
        'new_door_number',
        'old_address',
        'new_address',
        'floor',
        'construction_type',
        'percentage',
        'occupied',
        'floor_usage',
        'remarks',
        'shop_floor',
        'shop_name',
        'shop_owner_name',
        'license',
        'professional_tax',
        'shop_category',
        'shop_mobile',
        'establishment_remarks',
        'cctv',
        'head_room',
        'parking',
        'basement',
        'solar_panel',
        'water_connection',
        'over_headtank',
        'lift_room',
        'cellphone_tower',
        'eb_connection',
        'ugd',
        // Add more fields as needed
    ];
    public function images()
    {
        return $this->hasMany(image::class, 'gisid', 'gisid');
    }
}
