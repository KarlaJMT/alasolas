<div>
    <x-button wire:click="openModal" class="mb-4">Nuevo Servicio</x-button>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 dark:text-green-400">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full border-separate border-spacing-0 divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Nombre</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Tipo</th>
                    <th class="px-6 py-3 border-b border-r border-gray-300">Descripción</th>
                    <th class="px-6 py-3 border-b border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($services as $service)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 border-r border-gray-300">{{ $service->nombre }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ $service->tipo }}</td>
                        <td class="px-6 py-4 border-r border-gray-300">{{ is_array($service->descripcion) ? implode(', ', $service->descripcion) : $service->descripcion }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="openModal({{ $service->id }})"
                                class="text-indigo-600 dark:text-indigo-400 mr-2">Editar</button>
                            <button wire:click="delete({{ $service->id }})" class="text-red-600 dark:text-red-400"
                                onclick="return confirm('¿Eliminar servicio?')">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $services->links() }}
    </div>

    @if($showModal)
        <x-modal wire:model="showModal" maxWidth="xl">
            <x-slot name="title">
                {{ $serviceId ? 'Editar Servicio' : 'Nuevo Servicio' }}
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                <x-input label="Nombre" wire:model="form.nombre" />
                <x-input label="Tipo" wire:model="form.tipo" />
                <x-textarea label="Descripción" wire:model="form.descripcion" rows="3" />
            </div>

            <!-- <x-slot name="footer"> -->
            <div class="flex justify-end gap-3">
                <x-button secondary wire:click="$set('showModal', false)">Cancelar</x-button>
                <x-button wire:click="save">{{ $serviceId ? 'Actualizar' : 'Guardar' }}</x-button>
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