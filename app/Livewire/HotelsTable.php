<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Hotel;

class HotelsTable extends Component
{
    use WithPagination;

    public $showModal = false;
    public $hotelId = null;
    public $form = [
        'nombre' => '',
        'direccion' => '',
        'contacto' => '',
        'telefono' => '',
        'categoria' => ''
    ];

    public $hotelFilter = '';

    protected $rules = [
        'form.nombre' => 'required|min:3|max:255',
        'form.direccion' => 'required|min:3|max:255',
        'form.contacto' => 'required|min:3|max:255',
        'form.telefono' => 'required|min:3|max:255',
        'form.categoria' => 'required|min:1|max:50'
    ];

    public function resetForm()
{
    $this->form = [
        'nombre' => '',
        'direccion' => '',
        'contacto' => '',
        'telefono' => '',
        'categoria' => '',
    ];
    $this->hotelId = null;
}

    public function openModal($id = null)
    {
        $this->resetForm();

        if ($id) {
            $hotel = Hotel::findOrFail($id);
            $this->hotelId = $hotel->id;
            $this->form = [
                'nombre' => $hotel->nombre,
                'direccion' => $hotel->direccion,
                'contacto' => $hotel->contacto,
                'telefono' => $hotel->telefono,
                'categoria' => $hotel->categoria,
            ];
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.nombre' => 'required|string|max:255',
            'form.direccion' => 'required|string|max:255',
            'form.contacto' => 'required|string|max:255',
            'form.telefono' => 'required|string|max:255',
            'form.categoria' => 'required|string|max:255',
        ]);

        if ($this->hotelId) {
            // Actualizar
            Hotel::find($this->hotelId)->update($this->form);
            session()->flash('message', 'Hotel actualizado correctamente.');
        } else {
            // Crear nuevo
            Hotel::create($this->form);
            session()->flash('message', 'Hotel creado correctamente.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        Hotel::destroy($id);
        session()->flash('message', 'Hotel eliminado');
    }

    public function updatingHotelFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Hotel::query();
        if ($this->hotelFilter) {
            $query->where('nombre', $this->hotelFilter);
        }
        return view('livewire.hotels-table', [
            'hotels' => $query->paginate(10),
            'hotelNames' => Hotel::pluck('nombre')->unique(),
        ]);
    }
}