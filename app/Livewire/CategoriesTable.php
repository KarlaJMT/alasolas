<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoriesTable extends Component
{
    use WithPagination;

    public $showModal = false;
    public $categoryId;
    public $form = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'is_active' => true
    ];

    protected $rules = [
        'form.name' => 'required|min:3|max:255',
        'form.slug' => 'required|min:3|max:255|unique:categories,slug',
        'form.description' => 'nullable|max:500',
        'form.is_active' => 'boolean'
    ];

    public function updatedCategoryId()
    {
        if ($this->categoryId) {
            $this->rules['form.slug'] = 'required|min:3|max:255|unique:categories,slug,' . $this->categoryId;
        }
    }

    public function openModal($id = null)
    {
        $this->resetErrorBag();
        $this->categoryId = $id;
        $this->reset('form');

        if ($id) {
            $category = Category::find($id);
            $this->form = $category->only(['name', 'slug', 'description', 'is_active']);
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->categoryId) {
            Category::find($this->categoryId)->update($this->form);
        } else {
            Category::create($this->form);
        }

        $this->showModal = false;
        session()->flash('message', 'Categoría guardada exitosamente');
    }

    public function delete($id)
    {
        Category::destroy($id);
        session()->flash('message', 'Categoría eliminada');
    }

    public function render()
    {
        return view('livewire.categories-table', [
            'categories' => Category::paginate(10)
        ]);
    }
}
