<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LecturaPhMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subjet = "REPORTE DE PH";
    
    protected $piscina = "";
    protected $lectura = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($piscina, $lectura)
    {
        $this->piscina = $piscina;
        $this->lectura = $lectura;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.lectura-ph-mailable', ["piscina" => $this->piscina, "lectura" => $this->lectura]);
    }
}
