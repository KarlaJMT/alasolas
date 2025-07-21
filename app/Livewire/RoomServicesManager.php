<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class RoomServicesManager extends Component
{
    use WithPagination;
    public ?int $roomEditingId = null;
    public array $selectedServices = [];
    public $showServiceModal = false;
    public $hotelFilter = '';
    public $pendingHotelFilter = '';

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

    public function applyHotelFilter()
    {
        $this->hotelFilter = $this->pendingHotelFilter;
        $this->resetPage();
    }

    public function render()
    {
        $services = Service::all();
        $query = Room::with('services', 'hotel');
        if ($this->hotelFilter) {
            $query->where('hotel_id', $this->hotelFilter);
        }
        $rooms = $query->paginate(5);
        $hotelNames = \App\Models\Hotel::pluck('nombre', 'id');
        return view('livewire.room-services-manager', compact('services', 'rooms', 'hotelNames'))
            ->with([
                'hotelFilter' => $this->hotelFilter,
                'pendingHotelFilter' => $this->pendingHotelFilter,
            ]);
    }
}