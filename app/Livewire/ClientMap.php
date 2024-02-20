<?php

namespace App\Livewire;

use Livewire\Component;

class ClientMap extends Component
{
    public $surveyed;

    public function mount()
    {
        // Fetch surveyed data and assign it to the property
        $this->surveyed = Surveyed::all();
    }

    public function render()
    {
        return view('livewire.client-map', ['surveyed' => $this->surveyed]);
    }
}
