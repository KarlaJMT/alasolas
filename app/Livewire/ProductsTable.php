<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductsTable extends Component
{
    use WithPagination;

    public $showModal = false;
    public $productId;
    public $form = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'price' => 0,
        'stock' => 0,
        'is_active' => true,
        'category_id' => null
    ];

    protected $rules = [
        'form.name' => 'required|min:3|max:255',
        'form.slug' => 'required|min:3|max:255|unique:products,slug',
        'form.description' => 'nullable',
        'form.price' => 'required|numeric|min:0',
        'form.stock' => 'required|integer|min:0',
        'form.is_active' => 'boolean',
        'form.category_id' => 'required|exists:categories,id'
    ];

    public function updatedProductId()
    {
        if ($this->productId) {
            $this->rules['form.slug'] = 'required|min:3|max:255|unique:products,slug,' . $this->productId;
        }
    }

    public function openModal($id = null)
    {
        $this->resetErrorBag();
        $this->productId = $id;
        $this->reset('form');

        if ($id) {
            $product = Product::find($id);
            $this->form = $product->only([
                'name',
                'slug',
                'description',
                'price',
                'stock',
                'is_active',
                'category_id'
            ]);
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->productId) {
            Product::find($this->productId)->update($this->form);
        } else {
            Product::create($this->form);
        }

        $this->showModal = false;
        session()->flash('message', 'Producto guardado exitosamente');
    }

    public function delete($id)
    {
        Product::destroy($id);
        session()->flash('message', 'Producto eliminado');
    }

    public function render()
    {
        return view('livewire.products-table', [
            'products' => Product::with('category')->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
