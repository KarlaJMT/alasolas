<div>
    <x-button wire:click="openModal" class="mb-4">Nuevo Hotel</x-button>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Dirección</th>
                    <th class="px-6 py-3 text-left">Contacto</th>
                    <th class="px-6 py-3 text-left">Teléfono</th>
                    <th class="px-6 py-3 text-left">Categoría</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($hotels as $hotel)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 dark:text-gray-300">{{ $hotel->nombre }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $hotel->direccion }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $hotel->contacto }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $hotel->telefono }}</td>
                        <td class="px-6 py-4 dark:text-gray-300">{{ $hotel->categoria }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="openModal({{ $hotel->id }})"
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                Editar
                            </button>
                            <button wire:click="delete({{ $hotel->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                onclick="return confirm('¿Eliminar hotel?')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $hotels->links() }}
    </div>

    <!-- Modal para Hotel -->
    @if($showModal)
        <x-modal wire:model="showModal" maxWidth="xl">
            <x-slot name="title">
                {{ $hotelId ? 'Editar Hotel' : 'Nuevo Hotel' }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Nombre" wire:model="form.nombre" />
                <x-input label="Dirección" wire:model="form.direccion" />
                <x-input label="Contacto" wire:model="form.contacto" />
                <x-input label="Teléfono" wire:model="form.telefono" />
                <x-input label="Categoría" wire:model="form.categoria" />
            </div>

            <!-- <x-slot name="footer"> -->
            <div class="flex justify-end gap-3">
                <x-button secondary wire:click="$set('showModal', false)">
                    Cancelar
                </x-button>
                <x-button wire:click="save" class="bg-red-500 text-white">
                    {{ $hotelId ? 'Actualizar' : 'Guardar' }}
                </x-button>
            </div>
            <!-- </x-slot> -->
            <div class="mt-4">
                <button wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>
            </div>
        </x-modal>
    @endif
</div>