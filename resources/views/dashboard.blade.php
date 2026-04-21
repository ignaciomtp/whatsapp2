<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ open: false, clienteNombre: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left rtl:text-right border-collapse table-auto">
                        <thead class="bg-neutral-secondary-soft border-b border-default">
                            <tr class="p-4">
                                <th class="p-4">Nombre</th>
                                <th class="p-4">Apellidos</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Teléfono</th>
                                <th class="p-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr class="odd:bg-neutral-primary p-4 even:bg-neutral-secondary-soft border-b border-default">
                                <td class="p-4">{{ $cliente->nombre }}</td>
                                <td class="p-4">{{ $cliente->apellidos }}</td>
                                <td class="p-4">{{ $cliente->email }}</td>
                                <td class="p-4">{{ $cliente->telefono }}</td>
                                <td class="p-4">
                                    <button
                                        type="button"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        @click="clienteNombre = '{{ $cliente->nombre }}'; open = true"
                                    >
                                        Mensaje
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            x-show="open"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            @click.self="open = false"
        >
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                <!-- Cabecera -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold" x-text="'Mensaje para ' + clienteNombre"></h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-xl leading-none">✕</button>
                </div>

                <!-- Contenido -->
                <textarea
                    class="w-full border border-gray-300 rounded p-2 text-sm"
                    rows="4"
                    :placeholder="'Escribe un mensaje para ' + clienteNombre + '...'"
                ></textarea>

                <!-- Pie -->
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 border rounded hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
