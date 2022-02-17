<?php

namespace App\Http\Controllers;

use App\Jobs\LecturaPiscinaJob;
use App\Models\LecturaPiscina;
use App\Models\Piscina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        LecturaPiscinaJob::dispatch($piscina, $data["lectura"]);

        return response()->json("OK", 200);
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
