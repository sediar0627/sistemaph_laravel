<div>
    <div>
        <div class="flex flex-col xl:flex-row items-center justify-center w-full pt-4">
            <p class="font-medium text-sm text-gray-700 xl:mr-5">NOMBRE</p>
            <input wire:model.lazy="piscina.nombre" type="text" class="text-black placeholder-gray-600 w-40 px-4 py-2.5 my-4 xl:m-0 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            <p class="font-medium text-sm text-gray-700 xl:mr-5 xl:ml-5">LITROS DE LA PISCINA</p>
            <input wire:model.lazy="piscina.litros" type="text" class="text-black placeholder-gray-600 w-32 px-4 py-2.5 my-4 xl:m-0 text-base transition duration-500 ease-in-out transform border-transparent rounded-lg bg-gray-300 focus:border-blueGray-500 focus:bg-white dark:focus:bg-gray-800 focus:outline-none focus:ring-2 ring-offset-current ring-gray-500">
            <button wire:click="GuardarPiscina" class="xl:ml-5 w-64 px-4 py-2.5 rounded-xl focus:outline-none bg-indigo-500 text-white hover:bg-indigo-600">
                GUARDAR PISCINA
                <svg wire:loading wire:target="GuardarPiscina" class="animate-spin inline-block ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
            <button wire:click="LimpiarCampos" class="xl:ml-5 xl:mt-0 mt-2 w-64 px-4 py-2.5 rounded-xl focus:outline-none bg-red-400 text-white hover:bg-red-500">
                LIMPIAR CAMPOS
                <svg wire:loading wire:target="LimpiarCampos" class="animate-spin inline-block ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" style="display: none;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center w-full mt-3">
            @error('piscina.nombre')
            <span class="error pt-4">{{ $message }}</span>
            @enderror
            @error('piscina.litros')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="px-4 py-4">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 xl:-mx-8 xl:px-8">
            <div class="align-middle inline-block min-w-full overflow-hidden sm:rounded-lg border-2 border-gray-300">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                CODIGO
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                NOMBRE
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                CAPACIDAD EN LITROS
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if($piscinas->count() > 0)
                        @foreach ($piscinas as $piscina)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                <div class="flex items-center justify-center text-sm leading-5 text-gray-900">
                                    <span>
                                        <span>{{ $piscina->uuid }}</span>
                                        <span class="ml-1 text-indigo-500 font-medium cursor-pointer" onclick="CopiarUuid('{{ $piscina->uuid }}')" id="copiar_{{ $piscina->uuid }}">Copiar</span>
                                    </span>
                                </div>
                            </td>

                            <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                <div class="text-sm leading-5 text-gray-900">{{ $piscina->nombre }}</div>
                            </td>

                            <td class="px-3 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                <div class="text-sm leading-5 text-gray-900">{{ $piscina->litros }} L</div>
                            </td>

                            <td class="py-4 whitespace-no-wrap border-b border-gray-200 leading-5 text-gray-500">
                                <div class="flex item-center justify-center">
                                    <div wire:click="BuscarPiscina('{{ $piscina->uuid }}')" class="mr-2 transform hover:text-indigo-500 hover:scale-110 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <div wire:click="EliminarPiscina('{{ $piscina->uuid }}')" class="mr-2 transform hover:text-red-400 hover:scale-110 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="py-4 whitespace-no-wrap border-b text-center border-gray-200 leading-5 text-gray-500" colspan="3"></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function CopiarUuid(uuid) {
            navigator.clipboard.writeText(uuid);
            $("#copiar_" + uuid).removeClass("text-indigo-500");
            $("#copiar_" + uuid).addClass("text-green-500");
            setTimeout(function() {
                $("#copiar_" + uuid).removeClass("text-green-500");
                $("#copiar_" + uuid).addClass("text-indigo-500");
            }, 1000);
        }
    </script>
</div>
