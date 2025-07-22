<?php

// namespace App\Livewire;
namespace App\Http\Livewire;

use Livewire\Component;

class MapLocationPicker extends Component
{
    public $latitude;
    public $longitude;
    protected $listeners=['updateCoordinates'];

    public function mount($latitude = null, $longitude = null) {
        $this->latitude = $latitude ?? 0;
        $this->longitude = $longitude ?? 0;
    }

    public function updateCoordinates($lat, $lng) {
        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->emitUp('coordinatesUpdated', $this->latitude, $this->longitude);
    }
    public function render()
    {
        return view('livewire.map-location-picker');
    }
}
