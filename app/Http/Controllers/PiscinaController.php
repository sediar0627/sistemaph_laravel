<?php

namespace App\Http\Controllers;

use App\Models\LecturaPiscina;
use App\Models\Notificacion;
use App\Models\Piscina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PiscinaController extends Controller
{
    public function lectura_prueba(Request $request, $uuid_piscina, $lectura)
    {

        $data = [
            'codigo_piscina' => $uuid_piscina,
            'lectura' => $lectura
        ];

        $validate_request = Validator::make($data, [
            'codigo_piscina' => 'required|uuid|exists:App\Models\Piscina,uuid',
            'lectura' => 'required|numeric'
        ]);

        if ($validate_request->fails()) {
            return response()->json("bad_request", 400);
        }

        $data = $validate_request->validate();

        $piscina = Piscina::where("uuid", $data["codigo_piscina"])->first();

        $lectura = LecturaPiscina::create([
            'lectura' => $data["lectura"],
            'piscina_id' => $piscina->id
        ]);

        if ($lectura->lectura <= 6.5 || $lectura->lectura >= 7.5) {

            $ultima_notificacion = Notificacion::where('piscina_id', $piscina->id)
                ->latest('id')
                ->first();

            if ($ultima_notificacion != null) {

                $minutos_diferencia = Carbon::now()->diffInMinutes($ultima_notificacion->updated_at);

                if($minutos_diferencia > 5){
                    $notificacion = Notificacion::create([
                        'estado' => Notificacion::ESTADOS["PENDIENTE"],
                        'mensaje' => "LA PISCINA " . strtoupper($piscina->nombre) . " TIENE UN PH DE " . $lectura->lectura,
                        'lectura_piscina_id' => $lectura->id,
                        'piscina_id' => $piscina->id
                    ]);
                } else {
                    Notificacion::create([
                        'estado' => Notificacion::ESTADOS["ENVIADA"],
                        'mensaje' => "LA PISCINA " . strtoupper($piscina->nombre) . " TIENE UN PH DE " . $lectura->lectura,
                        'lectura_piscina_id' => $lectura->id,
                        'piscina_id' => $piscina->id
                    ]);
                }

            } else {
                $notificacion = Notificacion::create([
                    'estado' => Notificacion::ESTADOS["PENDIENTE"],
                    'mensaje' => "LA PISCINA " . strtoupper($piscina->nombre) . " TIENE UN PH DE " . $lectura->lectura,
                    'lectura_piscina_id' => $lectura->id,
                    'piscina_id' => $piscina->id
                ]);
            }

            // Http::post('http://localhost:1000/reportar', [
            //     "telefono" => $piscina->usuario->phone,
            //     "mensajes" => $notificacion->mensajes,
            // ]);

        }

        return response()->json("OK", 200);
    }

    public function lectura_arduino(Request $request)
    {
        $request_data = $request->only('codigo_piscina', 'lectura');

        $validate_request = Validator::make($request_data, [
            'codigo_piscina' => 'required|uuid|exists:App\Models\Piscina,uuid',
            'lectura' => 'required|numeric'
        ]);

        if ($validate_request->fails()) {
            return response()->json(array(
                'status' => 'bad_request',
                'mensajes' => 'Los campos de la peticion son invalidos.',
                'errores' => $validate_request->errors()
            ), 400);
        }

        $data = $validate_request->validate();

        $piscina = Piscina::where("uuid", $data["codigo_piscina"])->first();

        $lectura = LecturaPiscina::create([
            'lectura' => $data["lectura"],
            'piscina_id' => $piscina->id
        ]);

        if ($lectura->lectura <= 6.5 || $lectura->lectura >= 7.5) {

            $notificacion = Notificacion::create([
                'estado' => Notificacion::ESTADOS["PENDIENTE"],
                'mensajes' => "LA PISCINA " . strtoupper($piscina->nombre) . ",TIENE UN PH DE " . $lectura->lectura,
                'lectura_piscina_id' => $lectura->id
            ]);

            // Http::post('http://localhost:1000/reportar', [
            //     "telefono" => $piscina->usuario->phone,
            //     "mensajes" => $notificacion->mensajes,
            // ]);
        }

        return response()->json(array(
            'status' => 'success',
            'mensajes' => "Creado",
            'lectura' => $lectura
        ), 200);
    }

    public function notificacion_envidada()
    {
    }

    public function cant_lecturas()
    {
        $cantidad = 0;
        $piscinas = Auth::user()->piscinas;
        foreach ($piscinas as $piscina) {
            $cantidad += $piscina->lecturas->count();
        }
        return response()->json($cantidad, 200);
    }

    public function lecturas()
    {

        $data = [];

        $piscinas = Auth::user()->piscinas;

        foreach ($piscinas as $piscina) {

            $lecturas_coleccion = LecturaPiscina::where("piscina_id", $piscina->id)
                ->orderByDesc("id")
                ->take(10)
                ->get();

            $fechas = $lecturas_coleccion->pluck('created_at')
                ->map(function ($fecha) {
                    return $fecha->format('Y-m-d H:i:s');
                })->toArray();

            $lecturas = $lecturas_coleccion
                ->pluck('lectura')
                ->toArray();

            if (count($lecturas) > 0) {
                $data[$piscina->nombre] = [
                    "fechas" => $fechas,
                    "lecturas" => $lecturas
                ];
            }
        }

        return response()->json($data, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return \Illuminate\Http\Response
     */
    public function show(Piscina $piscina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return \Illuminate\Http\Response
     */
    public function edit(Piscina $piscina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Piscina  $piscina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piscina $piscina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piscina $piscina)
    {
        //
    }
}
