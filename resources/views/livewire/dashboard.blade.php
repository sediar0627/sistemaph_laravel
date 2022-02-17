<div class="holder mx-auto flex flex-col items-center p-4">
    @foreach ($lecturas as $lectura)
    <div class="w-80 lg:w-2/4 each my-4 m-2 shadow-lg border-gray-800 bg-gray-200 sm:rounded-lg relative">
        <div class="badge absolute top-2 left-2 {{ $lectura->lectura < \App\Models\LecturaPiscina::VALOR_MINIMO_CORRECTO || $lectura->lectura > \App\Models\LecturaPiscina::VALOR_MAXIMO_CORRECTO ? 'bg-red-500' : 'bg-indigo-500' }} m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">PISCINA {{ strtoupper($lectura->piscina->nombre) }}</div>
        <div class="badge absolute top-2 right-2 {{ $lectura->lectura < \App\Models\LecturaPiscina::VALOR_MINIMO_CORRECTO || $lectura->lectura > \App\Models\LecturaPiscina::VALOR_MAXIMO_CORRECTO ? 'bg-red-500' : 'bg-indigo-500' }} m-1 text-gray-200 p-1 px-2 text-xs font-bold rounded">{{ $lectura->created_at }}</div>
        <div class="desc p-4 mt-8">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block w-full overflow-hidden sm:rounded-lg border-2 border-gray-300">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    CAMPO
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    VALOR
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">LECTURA</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $lectura->lectura }}</div>
                                </td>
                            </tr>
                            @if($lectura->notificacion != null)

                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">SMS</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    @if ($lectura->notificacion->estado_sms == 1)
                                    <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">PENDIENTE</span>
                                    @elseif ($lectura->notificacion->estado_sms == 2)
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">ENVIADA</span>
                                    @elseif ($lectura->notificacion->estado_sms == 3)
                                    <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">ERROR</span>
                                    @endif
                                </td>
                            </tr>

                            @if($lectura->notificacion->estado_sms == 2)
                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">ENVIO SMS</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $lectura->notificacion->fecha_sms }}</div>
                                </td>
                            </tr>
                            @endif

                            @if($lectura->notificacion->estado_sms == 3)
                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">OBSERVACION SMS</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $lectura->notificacion->observacion_sms }}</div>
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">WHATSAPP</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    @if ($lectura->notificacion->estado_whatsapp == 1)
                                    <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">PENDIENTE</span>
                                    @elseif ($lectura->notificacion->estado_whatsapp == 2)
                                    <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">ENVIADA</span>
                                    @elseif ($lectura->notificacion->estado_whatsapp == 3)
                                    <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">ERROR</span>
                                    @endif
                                </td>
                            </tr>

                            @if($lectura->notificacion->estado_whatsapp == 2)
                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">ENVIO WHATSAPP</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $lectura->notificacion->fecha_whatsapp }}</div>
                                </td>
                            </tr>
                            @endif

                            @if($lectura->notificacion->estado_whatsapp == 3)
                            <tr>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">OBSERVACION WHATSAPP</div>
                                </td>
                                <td class="py-2 px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 font-medium text-gray-900">{{ $lectura->notificacion->observacion_whatsapp }}</div>
                                </td>
                            </tr>
                            @endif

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
