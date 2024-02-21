<?php

namespace App\Livewire;
use App\Models\Surveyed;
use Livewire\Component;

class ClientMap extends Component
{
    public $surveyed;
    public $point;
    public $longitude;
    public $latitude;
    public $gis_id;

    protected $listeners = ['addFeature'];


    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->point = asset('public/kovai/test.json');
        $this->surveyed = Surveyed::all();
    }
    public function addFeature($p,$p1)
    {
        // Load existing JSON data
        $data = json_decode(file_get_contents(public_path('kovai/test.json')), true);

        // Assuming 'features' is an existing array in your JSON data
        $features = $data['features'];

        // Primary GIS ID
        $primaryGisId = $request->input('primary_gis_id');

        // Prepare the new feature
        $newFeature = [
            "type" => "Feature",
            "id" => count($features), // Assigning an ID based on the current number of features
            "geometry" => [
                "type" => "Point",
                "coordinates" => [
                    $request->input('longitude'),
                    $request->input('latitude')
                ]
            ],
            "properties" => [
                "FID" => count($features), // Using the same ID as 'id' for simplicity
                "Id" => 0,
                "GIS_ID" => count($features) + 1
            ]
        ];

        // Add the new feature to the existing features array
        $features[] = $newFeature;

        // Update the 'features' array in the JSON data
        $data['features'] = $features;

        // Write the updated JSON data back to the file
        file_put_contents(public_path('kovai/test.json'), json_encode($data, JSON_PRETTY_PRINT));

        return response()->json(['message' => 'Feature added successfully']);
    }

    public function render()
    {
        return view('livewire.client-map', [
            'surveyed' => $this->surveyed
        ]);
    }
}
