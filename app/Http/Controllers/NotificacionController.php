<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function pendientes_whatsapp()
    {
        $notificaciones = Notificacion::select("id", "mensaje", "telefono")
            ->where("estado_whatsapp", Notificacion::ESTADOS["PENDIENTE"])
            ->get()
            ->toArray();

        return response()->json($notificaciones, 200);
    }

    public function pendientes_whatsapp_procesado($id){
        $notificacion = Notificacion::find($id);
        $notificacion->estado_whatsapp = Notificacion::ESTADOS["ENVIADA"];
        $notificacion->fecha_whatsapp = Carbon::now();
        $notificacion->save();
        return response()->json($id, 200);
    }
}
