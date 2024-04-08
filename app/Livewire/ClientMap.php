<?php

namespace App\Livewire;

use App\Models\BuildingData;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClientMap extends Component
{
    use WithFileUploads;

    public $point_data;
    public $point;
    public $longitude;
    public $latitude;
    public $gis_id;
    public $building_data;
    public $road_names; // Renamed to avoid conflict with form field
    public $surveyed;

    public $gisid, $number_bill, $number_floor, $watet_tax, $liftroom, $headroom, $overhead_tank,
           $percentage, $new_address, $eb, $building_name, $building_usage, $construction_type,
           $road_name_form, // Renamed to avoid conflict with other road_name property
           $ugd, $rainwater_harvesting, $parking, $ramp, $hoarding, $cell_tower,
           $solar_panel, $water_connection, $phone, $image;

    protected $listeners = [
        'addFeature',
        'refreshData' => '$refresh',
        'clientmap' => 'refreshData'
    ];

    public function mount()
    {
        $this->point = asset('public/kovai/test.json');
        $this->surveyed = PointData::all();
        $this->building_data = BuildingData::all();
        $this->road_names = mis::distinct('road_name')
            ->selectRaw('road_name, count(*) as total_road_count')
            ->groupBy('road_name')
            ->get();
    }

    public function submitForm()
    {
        $validatedData = $this->validate([
            'gisid' => 'required',
            'number_bill' => 'required',
            'number_floor' => 'required',
            // Add validation rules for other fields
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $buildingData = BuildingData::where('gisid', $validatedData['gisid'])->first();

        if ($buildingData) {
            // Update existing record
            $buildingData->update($validatedData);
        } else {
            // Create new record
            $buildingData = new BuildingData($validatedData);
            $buildingData->image = $this->image->store('images', 'public');
            $buildingData->save();
        }

        session()->flash('message', 'Data saved successfully!');

        $this->reset(); // Reset form fields
    }

    public function refreshData()
    {
        $this->mount(); // Re-fetch data
    }

    public function render()
    {
        return view('livewire.client-map', [
            'surveyed' => $this->surveyed,
            'building_data' => $this->building_data,
            'road_names' => $this->road_names // Pass road_names to the view
        ]);
    }
}
