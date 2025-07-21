<div>
    <h2 class="text-2xl font-bold mb-4">Servicios por habitación</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center mb-4">
        <label for="hotelFilter" class="mr-2 font-semibold">Filtrar por hotel:</label>
        <select id="hotelFilter" wire:model="pendingHotelFilter" class="border rounded px-2 py-1 bg-white text-black dark:bg-gray-200 dark:text-black">
            <option value="">Todos</option>
            @foreach($hotelNames as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <button wire:click="applyHotelFilter" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Filtrar</button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border-separate border-spacing-0 divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Hotel</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Habitación</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Servicios</th>
                    <th class="px-6 py-3 border-b border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($rooms as $room)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->hotel->nombre ?? '—' }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ $room->nombre }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">
                            @if ($room->services->count())
                                {{ $room->services->pluck('nombre')->implode(' | ') }}
                            @else
                                <span class="text-gray-500 italic">Sin servicios</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="editServices({{ $room->id }})"
                                class="text-indigo-600 dark:text-indigo-400 mr-2">Editar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $rooms->links() }}
    </div>

    {{-- Modal para editar servicios --}}
    @if($showServiceModal)
        <x-modal wire:model="showServiceModal" maxWidth="xl">
            <x-slot name="title">
                Editar servicios: {{ optional($rooms->firstWhere('id', $roomEditingId))->nombre ?? '' }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($services as $service)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" wire:model="selectedServices" value="{{ $service->id }}">
                        <span>{{ $service->nombre }}</span>
                    </label>
                @endforeach
            </div>

            <!-- <x-slot name="footer"> -->
                <div class="flex justify-end gap-3">
                    <x-button secondary wire:click="$set('showServiceModal', false)">Cancelar</x-button>
                    <x-button wire:click="updateRoomServices">Guardar</x-button>
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
