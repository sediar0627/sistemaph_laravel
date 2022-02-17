<div>
    <style>
        .contenedor {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 1em;
            justify-content: center;
            padding: 1em;
        }

        .canva {
            min-width: 300px !important;
            min-height: 150px !important;
            width: 80% !important;
            height: 50% !important;
            max-width: 500px !important;
            max-height: 250px !important;
        }
    </style>

    <div id="contenedor_principal" class="divide-y"></div>

    <script>
        const nombres_piscinas = JSON.parse("{{ $piscinas }}".replaceAll("&quot;", "\""));
        nombres_piscinas.forEach(nombre => {
            $("#contenedor_principal").append(`
                <div class="flex flex-col lg:flex-row gap-4 p-4 items-center justify-center w-full">
                    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="align-middle inline-block min-w-full overflow-hidden sm:rounded-lg border-2 border-gray-300">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            LECTURA N°
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            VALOR
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                            FECHA
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_${nombre}" class="bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="contenedor_canva_${nombre}" class="flex items-center justify-center"></div>
                </div>
            `);
        });

        let cant_lecturas_iniciales = parseInt("{{ $cantidad_lecturas_inicial }}");
        let cant_lecturas = cant_lecturas_iniciales;

        const cantidad_lecturas = () => {
            $.ajax({
                type: 'POST',
                url: "{{ URL::to('/') }}/lecturas/cantidad",
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                }),
                contentType: "application/json",
                success: function(res) {
                    cant_lecturas = res;
                },
                error: function(xhr, status) {
                    console.log(xhr.responseJSON.errores);
                },
            });
        };

        function Color() {
            var simbolos, color;
            simbolos = "0123456789ABCDEF";
            color = "#";
            for (var i = 0; i < 6; i++) {
                color = color + simbolos[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function graficas() {
            $.ajax({
                type: 'POST',
                url: "{{ URL::to('/') }}/lecturas",
                data: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                }),
                contentType: "application/json",
                success: function(res) {
                    piscinas = Object.keys(res);
                    piscinas.forEach(piscina => {

                        const data = res[piscina];

                        const fechas = data["fechas"];
                        const lecturas = data["lecturas"];

                        $("#tbody_" + piscina).empty();

                        for (const index in lecturas) {

                            const fecha = fechas[index];
                            const lectura = lecturas[index];

                            $("#tbody_" + piscina).append(`
                                <tr>
                                    <td class="px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                        <div class="text-sm leading-5 text-gray-900">${parseInt(index)+1}</div>
                                    </td>

                                    <td class="px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                        <div class="text-sm leading-5 ${(parseFloat(lectura) > 6.5 && parseFloat(lectura) < 7.5 ? 'text-gray-900' : 'text-red-600 font-medium')}">${lectura}</div>
                                    </td>

                                    <td class="px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                        <div class="text-sm leading-5 text-gray-900">${fecha}</div>
                                    </td>
                                </tr>
                            `);
                        }

                        $("#contenedor_canva_" + piscina).empty();
                        $("#contenedor_canva_" + piscina).append(`
                            <canvas id="canva_${piscina}" class="my-4 canva"></canvas>
                        `);

                        let canva = document.getElementById("canva_" + piscina);
                        let ctx = canva.getContext('2d');
                        ctx.clearRect(0, 0, canva.width, canva.height);

                        let labels = [];
                        for (let index = 1; index <= fechas.length; index++) {
                            labels.push(index);
                        }

                        const chart = {
                            labels: labels,
                            datasets: [{
                                label: piscina.toUpperCase(),
                                data: lecturas,
                                fill: false,
                                borderColor: Color(),
                                tension: 0.1
                            }]
                        };

                        new Chart(ctx, {
                            type: 'line',
                            data: chart
                        });
                    });
                },
                error: function(xhr, status) {
                    console.log(xhr.responseJSON.errores);
                },
            });
        };

        graficas();

        setInterval(async () => {
            await cantidad_lecturas();
            if(cant_lecturas_iniciales != cant_lecturas){
                cant_lecturas_iniciales = cant_lecturas;
                graficas();
            }
        }, 1000);
    </script>

</div>
