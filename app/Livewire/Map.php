<?php

namespace App\Http\Livewire; // Adjust the namespace to match the correct directory structure

use App\Models\Surveyed; // Import the Surveyed model
use Livewire\Component;

class Map extends Component
{
    public $surveyed;

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->surveyed = Surveyed::all();
    }

    public function render()
    {
        // Pass the $surveyed data to the view
        return view('livewire.map', ['surveyed' => $this->surveyed]);
    }
}
