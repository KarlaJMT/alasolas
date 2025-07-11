<div>
    <x-button wire:click="openModal" class="mb-4">Nueva Categoría</x-button>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Slug</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($categories as $category)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 dark:text-gray-300">{{ $category->name }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $category->slug }}</td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Activa</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactiva</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="openModal({{ $category->id }})"
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                Editar
                            </button>
                            <button wire:click="delete({{ $category->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                onclick="return confirm('¿Eliminar categoría?')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }} 
    </div>

    <!-- Modal para Categoría -->
    @if($showModal)

        <x-modal wire:model="showModal" maxWidth="xl">
            <x-slot name="title">
                {{ $categoryId ? 'Editar Categoría' : 'Nueva Categoría' }}
            </x-slot>

            <div class="grid grid-cols-1 gap-4">
                <x-input label="Nombre" wire:model="form.name" />
                <x-input label="Slug" wire:model="form.slug" />
                <x-textarea label="Descripción" wire:model="form.description" rows="3" />
                <x-checkbox label="Activa" wire:model="form.is_active" />
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-3">
                    <x-button secondary wire:click="$set('showModal', false)">
                        Cancelar
                    </x-button>
                    <x-button wire:click="save">
                        {{ $categoryId ? 'Actualizar' : 'Guardar' }}
                    </x-button>
                </div>
            </x-slot>
        </x-modal>
    @endif

</div>