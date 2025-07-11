<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Service;
use Livewire\WithPagination;

class RoomsTable extends Component
{
    use WithPagination;

    public $form = [
        'hotel_id' => '',
        'nombre' => '',
        'num_max_personas' => '',
        'camas' => '',
        'costo_noche' => '',
        'services' => [],
    ];

    public $roomId = null;
    public $showModal = false;

    public function render()
    {
        return view('livewire.rooms-table', [
            'rooms' => Room::with('hotel', 'services')->paginate(10),
            'hotels' => Hotel::all(),
            'servicesList' => Service::all(),
        ]);
    }

    public function openModal($id = null)
    {
        $this->resetForm();

        if ($id) {
            $room = Room::with('services')->findOrFail($id);
            $this->roomId = $room->id;
            $this->form = [
                'hotel_id' => $room->hotel_id,
                'nombre' => $room->nombre,
                'num_max_personas' => $room->num_max_personas,
                'camas' => $room->camas,
                'costo_noche' => $room->costo_noche,
                'services' => $room->services->pluck('id')->toArray(),
            ];
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.hotel_id' => 'required|exists:hotels,id',
            'form.nombre' => 'required|string|max:255',
            'form.num_max_personas' => 'required|integer',
            'form.camas' => 'required|integer',
            'form.costo_noche' => 'required|numeric',
            'form.services' => 'array',
        ]);

        if ($this->roomId) {
            $room = Room::find($this->roomId);
            $room->update($this->form);
        } else {
            $room = Room::create($this->form);
        }

        $room->services()->sync($this->form['services'] ?? []);

        session()->flash('message', $this->roomId ? 'Habitación actualizada.' : 'Habitación creada.');

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        Room::destroy($id);
        session()->flash('message', 'Habitación eliminada.');
    }

    public function resetForm()
    {
        $this->form = [
            'hotel_id' => '',
            'nombre' => '',
            'num_max_personas' => '',
            'camas' => '',
            'costo_noche' => '',
            'services' => [],
        ];
        $this->roomId = null;
    }
}
