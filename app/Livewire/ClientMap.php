<?php

namespace App\Http\Livewire;

use App\Models\Surveyed;
use Livewire\Component;

class ClientMap extends Component
{
    public $surveyed;

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->surveyed = Surveyed::all();
    }

    public function addFeature($data)
    {
        // Load existing JSON data
        $jsonData = json_decode(file_get_contents(public_path('kovai/test.json')), true);

        // Assuming 'features' is an existing array in your JSON data
        $features = $jsonData['features'];

        // Prepare the new feature
        $newFeature = [
            "type" => "Feature",
            "id" => count($features), // Assigning an ID based on the current number of features
            "geometry" => [
                "type" => "Point",
                "coordinates" => [
                    $data['longitude'],
                    $data['latitude']
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
        $jsonData['features'] = $features;

        // Write the updated JSON data back to the file
        file_put_contents(public_path('kovai/test.json'), json_encode($jsonData, JSON_PRETTY_PRINT));

        return response()->json(['message' => 'Feature added successfully']);
    }

    public function render()
    {
        return view('livewire.client-map');
    }
}
