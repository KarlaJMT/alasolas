<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Service;
use Livewire\Component;

class RoomServicesManager extends Component
{
    public ?int $roomEditingId = null;
    public array $selectedServices = [];
    public $showServiceModal = false;

    public function mount()
    {
        $this->selectedServices = [];
    }

    public function editServices($roomId)
    {
        $this->roomEditingId = $roomId;
        $room = Room::with('services')->findOrFail($roomId);
        $this->selectedServices = $room->services->pluck('id')->toArray();
        $this->showServiceModal = true;
    }

    public function save()
    {
        if ($this->roomEditingId) {
            $room = Room::findOrFail($this->roomEditingId);
            $room->services()->sync($this->selectedServices);
            $this->showServiceModal = false;
            session()->flash('success', 'Servicios actualizados correctamente.');
        }
    }

    public function render()
    {
        $services = Service::all();
        $rooms = Room::with('services', 'hotel')->get();
        return view('livewire.room-services-manager', compact('services', 'rooms'));
    }
}