<div>
    <h2 class="text-2xl font-bold mb-4">Servicios por habitación</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3">Hotel</th>
                    <th class="px-6 py-3">Habitación</th>
                    <th class="px-6 py-3">Servicios</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">{{ $room->hotel->nombre ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $room->nombre }}</td>
                        <td class="px-6 py-4">
                            @if ($room->services->count())
                                <ul class="list-disc pl-5">
                                    @foreach ($room->services as $service)
                                        <li>{{ $service->nombre }}</li>
                                    @endforeach
                                </ul>
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
