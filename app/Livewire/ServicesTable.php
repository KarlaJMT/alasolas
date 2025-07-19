<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;

class ServicesTable extends Component
{
    use WithPagination;

    public $form = [
        'nombre' => '',
        'tipo' => '',
        'descripcion' => '',
    ];
    public $serviceId = null;
    public $showModal = false;

    public function render()
    {
        return view('livewire.services-table', [
            'services' => Service::with('hotel')->paginate(10),
            
        ]);
    }

    public function openModal($id = null)
    {
        $this->resetForm();

        if ($id) {
            $service = Service::findOrFail($id);
            $this->serviceId = $service->id;
            $this->form = [
                'nombre' => $service->nombre,
                'tipo' => $service->tipo,
                'descripcion' => $service->descripcion,
            ];
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.nombre' => 'required|string|max:255',
            'form.tipo' => 'required|string|max:255',
            'form.descripcion' => 'required|string',
        ]);

        if ($this->serviceId) {
            Service::find($this->serviceId)->update($this->form);
            session()->flash('message', 'Servicio actualizado.');
        } else {
            Service::create($this->form);
            session()->flash('message', 'Servicio creado.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        Service::destroy($id);
        session()->flash('message', 'Servicio eliminado.');
    }

    public function resetForm()
    {
        $this->form = [
            
            'nombre' => '',
            'tipo' => '',
            'descripcion' => '',
        ];
        $this->serviceId = null;
    }
}