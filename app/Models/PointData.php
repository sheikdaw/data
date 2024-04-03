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
        'Floor',
        'bill_usage',
        'aadhar_no',
        'ration_no',
        'phone_numnber',
        'shop_floor',
        'shop_name',
        'shop_owner_name',
        'shop_category',
        'shop_mobile',
        'license',
        'professional_tax',
        'gst',
        'number_of_emplyee',
        'trade_income',
        'establishment_remarks',
        'gisid', // Assuming gisid is also fillable
    ];
    public function buildingData()
    {
        return $this->belongsTo(BuildingData::class);
    }
}
