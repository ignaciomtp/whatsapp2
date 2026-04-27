<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
            open: false,
            clienteNombre: '',
            clienteApellidos: '',
            clienteId: '',
            clienteTel: '',
            texto: '',
            imagenFile: null,
            enviando: false,
            enviado: false,
            allSelected: false,
            selected: [],
            clientesIds: {{ $clientes->pluck('id') }},
            async enviar() {
                this.enviando = true;
            
                let formData = new FormData();
                formData.append('cliente_id', this.clienteId);
                formData.append('texto', this.texto);
                
                // Si hay una imagen seleccionada, la añadimos
                if (this.imagenFile) {
                    formData.append('imagen', this.imagenFile);
                }

                await fetch('{{ route('store.mensaje') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                this.enviando = false;
                this.enviado = true;

                setTimeout(() => {
                    this.enviado = false;
                    this.open = false;
                    this.texto = '';
                }, 1500);

                this.open = false;
                this.texto = '';
            },
            checkClient(id) {
                
                const isIn = (element) => element == id;

                let idx = this.selected.findIndex(isIn);

                if(idx == -1) {
                    this.selected.push(id);
                } else {
                    this.selected.splice(idx, 1);
                }

                console.log(this.selected);
            },
            allCheckedToggle() {
                if (!this.allSelected) {
                    this.selected = [...this.clientesIds];
                } else {
                    this.selected = [];
                }

                this.allSelected = !this.allSelected;

                console.log(this.selected);
            },
            sendToAll() {
                console.log('send messages to all');
            }
        }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                    
                    <div class="float-right">
                        <button
                            type="button"
                            :disabled="selected.length < 2"  
                            @click="sendToAll"
                            class="bg-blue-500 hover:bg-blue-700 disabled:bg-blue-100 text-white font-bold py-2 px-4 border border-blue-700 disabled:border-blue-50 rounded">                                                              
                            Mensaje Múltiple
                        </button>
                    </div>
                    <div class="mb-4 text-sm text-gray-500">
                        Mostrando {{ $clientes->firstItem() }}–{{ $clientes->lastItem() }} de {{ $clientes->total() }} clientes
                    </div>
                    <table class="w-full text-left rtl:text-right border-collapse table-auto">
                        <thead class="bg-neutral-secondary-soft border-b border-default">
                            <tr class="p-4">
                                <th>
                                    <input type="checkbox" 
                                    @click="allCheckedToggle()"
                                    :checked="allSelected"
                                    class="border border-gray-300 rounded">
                                </th>
                                <th class="p-4">Id</th>
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
                                <td>
                                    <input type="checkbox" 
                                    @click="checkClient({{ $cliente->id }})"
                                    :checked="selected.includes({{ $cliente->id }})"
                                    class="border border-gray-300 rounded">
                                </td>
                                <td class="p-4">{{ $cliente->id }}</td>
                                <td class="p-4">{{ $cliente->nombre }}</td>
                                <td class="p-4">{{ $cliente->apellidos }}</td>
                                <td class="p-4">{{ $cliente->email }}</td>
                                <td class="p-4">{{ "+".$cliente->codigo_pais." ".$cliente->telefono }}</td>
                                <td class="p-4">
                                    <button
                                        type="button"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
                                        @click="clienteNombre = '{{ $cliente->nombre }}';
                                        clienteApellidos = '{{ $cliente->apellidos }}'; 
                                        clienteId = '{{ $cliente->id }}';
                                        clienteTel = '{{ $cliente->telefono }}';
                                        open = true"
                                    >
                                        Mensaje
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    <div class="mt-4">
                        {{ $clientes->links() }}
                    </div>
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
                    <h2 class="text-xl font-semibold" x-text="'Mensaje para ' + clienteNombre + ' ' + clienteApellidos"></h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-xl leading-none">✕</button>
                </div>

                <!-- Contenido -->
                <div class="mb-2">
                    <label class="text-sm text-gray-600">Imagen (opcional)</label>
                    <input 
                        type="file" 
                        name="imagen"
                        accept="image/*" 
                        @change="imagenFile = $event.target.files[0]"
                    >
                </div>
                <textarea
                    x-model="texto"
                    name="texto"
                    class="w-full border border-gray-300 rounded p-2 text-sm"
                    rows="4"
                    :placeholder="'Escribe un mensaje para ' + clienteNombre + '...'"
                ></textarea>

                <div class="mt-4 flex justify-start gap-2">
                    <input type="text" name="telefono" class="w-full border border-gray-300 rounded p-2 text-sm"
                    :value="clienteTel" x-model="clienteTel" readonly>

                    <input type="text" name="id" class="w-full border border-gray-300 rounded p-2 text-sm"
                    :value="clienteId" x-model="clienteId" readonly>
                </div>

                <!-- Pie -->
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 border rounded hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button @click="enviar()" :disabled="enviando" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Enviar
                    </button>
                    <div>
                        <span x-show="enviando">Enviando...</span>
                        <span x-show="enviado">¡Enviado! ✓</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
