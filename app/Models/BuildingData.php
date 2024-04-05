<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingData extends Model
{
    use HasFactory;
    protected $fillable = [
        'gisid',
        'number_bill',
        'overhead_tank',
        'liftroom',
        'percentage',
        'headroom',
        'new_address',
        'number_floor',
        'watet_tax',
        'eb',
        'building_name',
        'building_usage',
        'construction_type',
        'road_name',
        'ugd',
        'rainwater_harvesting',
        'parking',
        'ramp',
        'hoarding',
        'cell_tower',
        'solar_panel',
        'water_connection',
        'phone',
        'image'
        // Add other fillable fields here
    ];
    public function pointData()
    {
        return $this->hasMany(PointData::class);
    }
}
