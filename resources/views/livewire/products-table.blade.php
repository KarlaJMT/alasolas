<div>
    <x-button wire:click="openModal" class="mb-4">Nuevo Producto</x-button>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Categoría</th>
                    <th class="px-6 py-3 text-left">Precio</th>
                    <th class="px-6 py-3 text-left">Stock</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($products as $product)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 dark:text-gray-300">{{ $product->name }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">${{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $product->stock }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="openModal({{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                Editar
                            </button>
                            <button wire:click="delete({{ $product->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                onclick="return confirm('¿Eliminar producto?')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Modal para Producto -->
    @if($showModal)
        <x-modal wire:model="showModal" maxWidth="3xl">
            <x-slot name="title">
                {{ $productId ? 'Editar Producto' : 'Nuevo Producto' }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Nombre" wire:model="form.name" />
                <x-input label="Slug" wire:model="form.slug" />
                <x-select label="Categoría" wire:model="form.category_id" :options="$categories" option-label="name"
                    option-value="id" />
                <x-input label="Precio" wire:model="form.price" type="number" step="0.01" />
                <x-input label="Stock" wire:model="form.stock" type="number" />
                <x-checkbox label="Activo" wire:model="form.is_active" />
            </div>
            <div class="mt-4">
                <x-textarea label="Descripción" wire:model="form.description" rows="4" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <x-button secondary wire:click="$set('showModal', false)">
                        Cancelar
                    </x-button>
                    <x-button wire:click="save">
                        {{ $productId ? 'Actualizar' : 'Guardar' }}
                    </x-button>
                </div>
            </x-slot>
        </x-modal>
    @endif
</div>