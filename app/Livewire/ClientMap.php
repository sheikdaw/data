<?php

namespace App\Livewire;

use App\Models\Surveyed;
use App\Models\image;
use Livewire\Component;

class ClientMap extends Component
{
    public $point_data;
    public $point;
    public $longitude;
    public $latitude;
    public $gis_id;
    public $building_data;

    // Combine both listeners into one array
    protected $listeners = [
        'addFeature',
        'refreshData' => '$refresh'
    ];

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->point = asset('public/kovai/test.json');
        $this->point_data = point_data::all();
        $this->building_data = image::all();
    }

    public function render()
    {
        return view('livewire.client-map', [
            'surveyed' => $this->surveyed, 'building_data' => $this->building_data
        ]);
    }
}
