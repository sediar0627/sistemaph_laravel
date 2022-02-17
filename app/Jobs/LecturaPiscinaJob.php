<?php

namespace App\Jobs;

use App\Models\LecturaPiscina;
use App\Models\Notificacion;
use App\Models\Piscina;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class LecturaPiscinaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account;
    protected $apiKey;
    protected $token;

    protected $host_whatsapp;

    protected Piscina $piscina;
    protected float $lectura;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($piscina, $lectura)
    {
        $this->piscina = $piscina;
        $this->lectura = $lectura;

        $this->account = env('ACCOUNT_USER_SMS');
        $this->apiKey = env('API_KEY_SMS');
        $this->token = env('TOKEN_SMS');
    }

    public function enviar_notificacion(Notificacion $notificacion)
    {
        try {

            $data = [
                'toNumber' => '57' . $notificacion->telefono, //número de destino
                'sms' => $notificacion->mensaje, // mensaje de texto
                'flash' => '0', //mensaje tipo flash
                'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'account' => $this->account,
                'apiKey' => $this->apiKey,
                'token' => $this->token,
            ])
                ->withBody(json_encode($data), 'application/json')
                ->post('https://api103.hablame.co/api/sms/v3/send/priority');

            $responseData = $response->json();

            if (!is_array($responseData)) {
                $notificacion->estado_sms = Notificacion::ESTADOS["ERROR"];
                $notificacion->observacion_sms = "No pudimos enviarte el mensaje sms";
                $notificacion->save();
            }

            if (($responseData['status'] ?? null) != '1x000') {
                $notificacion->estado_sms = Notificacion::ESTADOS["ERROR"];
                $notificacion->observacion_sms = "No pudimos enviarte el mensaje sms";
                $notificacion->save();
            } else {
                $notificacion->estado_sms = Notificacion::ESTADOS["ENVIADA"];
                $notificacion->fecha_sms = Carbon::now();
                $notificacion->save();
            }
        } catch (\Throwable $th) {
            $notificacion->estado_sms = Notificacion::ESTADOS["ERROR"];
            $notificacion->observacion_sms = "No pudimos enviarte el mensaje sms";
            $notificacion->save();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lectura = LecturaPiscina::create([
            'lectura' => $this->lectura,
            'piscina_id' => $this->piscina->id
        ]);

        if ($lectura->lectura < LecturaPiscina::VALOR_MINIMO_CORRECTO || $lectura->lectura > LecturaPiscina::VALOR_MAXIMO_CORRECTO) {

            $cant_notificaciones = Notificacion::where('piscina_id', $this->piscina->id)
                ->where('created_at', '>=', Carbon::now()->subMinutes(2))
                ->where('estado_sms', Notificacion::ESTADOS["ENVIADA"])
                ->orWhere('estado_whatsapp', Notificacion::ESTADOS["ENVIADA"])
                ->count();

            if($cant_notificaciones == 0){

                $notificacion = Notificacion::create([
                    'mensaje' => "LA PISCINA " . strtoupper($this->piscina->nombre) . " TIENE UN PH DE " . $lectura->lectura,
                    'telefono' => $this->piscina->usuario->phone,
                    'estado_sms' => Notificacion::ESTADOS["PENDIENTE"],
                    'estado_whatsapp' => Notificacion::ESTADOS["PENDIENTE"],
                    'lectura_piscina_id' => $lectura->id,
                    'piscina_id' => $this->piscina->id
                ]);

                if ($this->piscina->usuario->phone != null) {
                    $this->enviar_notificacion($notificacion);
                } else {
                    $notificacion->estado_sms = Notificacion::ESTADOS["ERROR"];
                    $notificacion->observacion_sms = "No tienes un telefono registrado";

                    $notificacion->estado_whatsapp = Notificacion::ESTADOS["ERROR"];
                    $notificacion->observacion_whatsapp = "No tienes un telefono registrado";

                    $notificacion->save();
                }
            }
        }
    }
}
