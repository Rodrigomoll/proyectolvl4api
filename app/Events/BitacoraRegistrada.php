<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BitacoraRegistrada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $accion;
    public $mensaje;

    /**
     * Create a new event instance.
     *
     * @param string $mensaje
     */
    public function __construct(string $mensaje, $accion)
    {
        $this->accion = $accion;
        $this->mensaje = $mensaje;
    }
}
