<div>
    <x-button wire:click="openModal" class="mb-4">Nueva Habitación</x-button>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border-separate border-spacing-0 divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Hotel</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Nombre</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Máx. Personas</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Camas</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Costo</th>
                    <th class="px-6 py-3 border-b border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($rooms as $room)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->hotel->nombre ?? '—' }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->nombre }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->num_max_personas }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->camas }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">${{ number_format($room->costo_noche, 2) }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="openModal({{ $room->id }})"
                                class="text-indigo-600 dark:text-indigo-400 mr-2">Editar</button>
                            <button wire:click="delete({{ $room->id }})" class="text-red-600 dark:text-red-400"
                                onclick="return confirm('¿Eliminar habitación?')">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $rooms->links() }}
    </div>

    @if($showModal)
        <x-modal wire:model="showModal" maxWidth="xl">
            <x-slot name="title">
                {{ $roomId ? 'Editar Habitación' : 'Nueva Habitación' }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Hotel" wire:model="form.hotel_id">
                    <option value="">Selecciona un hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->nombre }}</option>
                    @endforeach
                </x-select>

                <x-input label="Nombre" wire:model="form.nombre" />
                <x-input label="Máximo de Personas" wire:model="form.num_max_personas" type="number" />
                <x-input label="Camas" wire:model="form.camas" type="number" />
                <x-input label="Costo por Noche" wire:model="form.costo_noche" type="number" step="0.01" />
            </div>

            <!-- <x-slot name="footer"> -->
            <div class="flex justify-end gap-3">
                <x-button secondary wire:click="$set('showModal', false)">Cancelar</x-button>
                <x-button wire:click="save">{{ $roomId ? 'Actualizar' : 'Guardar' }}</x-button>
            </div>
            <div class="mt-4">
                <button wire:click="save" class="bg-green-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>
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