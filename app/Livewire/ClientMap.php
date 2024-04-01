<?php

namespace App\Livewire;

use App\Models\Surveyed;
use App\Models\image;
use Livewire\Component;

class ClientMap extends Component
{
    public $surveyed;
    public $point;
    public $longitude;
    public $latitude;
    public $gis_id;
    public $surveyed_img;
    public $buildingpath;
    public $pngFilePath;

    // Combine both listeners into one array
    protected $listeners = [
        'addFeature',
        'refreshData' => '$refresh'
    ];

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->point = asset('public/kovai/test.json');
        $this->buildingpath = asset('public/kovai/building.json');
        $this->pngFilePath = asset('public/kovai/new/png2.png');
        $this->surveyed = Surveyed::all();
        $this->surveyed_img = image::all();
    }

    public function render()
    {
        return view('livewire.client-map', [
            'surveyed' => $this->surveyed, 'surveyed_img' => $this->surveyed_img
        ]);
    }
}
