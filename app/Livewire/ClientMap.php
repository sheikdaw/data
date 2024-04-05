<?php

namespace App\Livewire;

use App\Models\Surveyed;
use App\Models\mis;
use App\Models\image;
use App\Models\PointData;
use App\Models\BuildingData;
use Livewire\Component;

class ClientMap extends Component
{
    public $point_data;
    public $point;
    public $longitude;
    public $latitude;
    public $gis_id;
    public $building_data;
    public $road_name;

    // Combine both listeners into one array
    protected $listeners = [
        'addFeature',
        'refreshData' => '$refresh'
    ];

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->point = asset('public/kovai/test.json');
        $this->point_data = PointData::all();
        $this->building_data = BuildingData::all();
        $this->road_name = mis::distinct('road_name')
            ->selectRaw('road_name, count(*) as total_road_count')
            ->groupBy('road_name')
            ->get();
    }

    public function render()
    {
        return view('livewire.client-map', [
            'surveyed' => $this->point_data,
            'building_data' => $this->building_data,
            'road_name' => $this->road_name
        ]);
    }
}
