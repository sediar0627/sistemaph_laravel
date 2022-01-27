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
            width: 80% !important;
            height: 50% !important;
            max-width: 500px !important;
            max-height: 250px !important;
        }
    </style>

    <script>
        let lecturas = [];
    </script>

    <div class="divide-y">
        @foreach ($lecturas as $piscina => $lectura)
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
                                    FECHA
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($labels[$piscina] as $label)
                            <tr>
                                <td class="px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $loop->iteration }}</div>
                                </td>

                                <td class="px-3 whitespace-no-wrap border-b border-gray-200 text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $label }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <canvas id="canva_{{ $loop->iteration }}" class="canva my-4"></canvas>
        </div>
        <script>
            lecturas["{{ $piscina }}"] = JSON.parse("{{ $lectura }}");
        </script>
        @endforeach
    </div>

    <script>
        function Color() {
            var simbolos, color;
            simbolos = "0123456789ABCDEF";
            color = "#";
            for (var i = 0; i < 6; i++) {
                color = color + simbolos[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function Graficas() {
            let contador = 1;
            for (const piscina in lecturas) {
                let data = lecturas[piscina];
                let labels = [];
                for (let index = 1; index <= data.length; index++) {
                    labels.push(index);
                }
                let ctx = document.getElementById("canva_" + contador).getContext('2d');
                let color = Color();
                const chart = {
                    labels: labels,
                    datasets: [{
                        label: piscina.toUpperCase(),
                        data: data,
                        fill: false,
                        borderColor: color,
                        tension: 0.1
                    }]
                };
                new Chart(ctx, {
                    type: 'line',
                    data: chart
                });
                contador++;
            }
        }

        Graficas();
    </script>

</div>
