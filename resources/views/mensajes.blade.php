<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ open: false, clienteNombre: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="w-full text-left rtl:text-right border-collapse table-auto">
                        <thead class="bg-neutral-secondary-soft border-b border-default">
                            <tr class="p-4">
                                <th class="p-4">Id</th>
                                <th class="p-4">Fecha</th>
                                <th class="p-4">Texto</th>
                                <th class="p-4">Cliente</th>
                                <th class="p-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensajes as $mensaje)
                            <tr class="odd:bg-neutral-primary p-4 even:bg-neutral-secondary-soft border-b border-default">
                                <td class="p-4">{{ $mensaje->id }}</td>
                                <td class="p-4">{{ $mensaje->fecha }}</td>
                                <td class="p-4">{{ $mensaje->texto }}</td>
                                <td class="p-4"></td>
                                <td class="p-4">
                                    <button
                                        type="button"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        
                                    >
                                        ver
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $mensajes->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
