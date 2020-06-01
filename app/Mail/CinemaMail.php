<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CinemaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $array_ticket;
    public $datos_sesion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($array_ticket, $datos_sesion)
    {
        $this->array_ticket = $array_ticket;
        $this->datos_sesion = $datos_sesion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('cineonline@gmail.com')
            ->view('mail');
    }
}
