<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointData extends Model
{
    use HasFactory;
    protected $fillable = [
        'assessment',
        'old_assessment',
        'floor',
        'bill_usage',
        'aadhar_no',
        'ration_no',
        'phone_number',
        'shop_floor',
        'shop_name',
        'old_door_no',
        'new_door_no',
        'shop_owner_name',
        'shop_category',
        'shop_mobile',
        'license',
        'professional_tax',
        'gst',
        'number_of_employee',
        'trade_income',
        'establishment_remarks',
        'point_gisid', // Assuming gisid is also fillable
        'building_data_id', // Add building_data_id
    ];
    public function buildingData()
    {
        return $this->belongsTo(BuildingData::class);
    }
}
