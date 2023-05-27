<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// TODO, Enviar email
class EnviarEmail extends Mailable
{

    // * variables
    use Queueable, SerializesModels;

    // * Datos
    public $datos;

    // * Constructor
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    //* Construir email.
    public function build()
    {

        // ? No existe el remitente ?
        if (!$this->datos['remitente']) {
            throw new \Exception('No se encontró el remitente del email');
        }
        // ? No existe el cuerpo ?
        if (!$this->datos['cuerpo']) {
            throw new \Exception('No se encontró el mensaje del email');
        }

        // * Enviamos email con su vista
        return $this->from(config('mail.from.address'))
            // Titulo
            ->subject('Hola, saludos de ' .  $this->datos['remitente'])
            // Vista
            ->view('emails.vista')
            // Datos a enviar
            ->with([
                'datos', $this->datos['cuerpo'],
            ]);
    }
}
