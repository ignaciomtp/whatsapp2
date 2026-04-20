<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left rtl:text-right text-body">
                      <thead class="bg-neutral-secondary-soft border-b border-default">
                        <tr>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                          <th>Email</th>
                          <th>Teléfono</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($clientes as $cliente)  
                        <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                          <td>{{ $cliente->nombre }}</td>
                          <td>{{ $cliente->apellidos }}</td>
                          <td>{{ $cliente->email }}</td>
                          <td>{{ $cliente->telefono }}</td>
                          <td></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

