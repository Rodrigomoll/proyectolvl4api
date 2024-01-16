<?php

namespace App\Listeners;

use App\Events\BitacoraRegistrada;
use App\Models\Bitacoras;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrarEnBitacora implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param BitacoraRegistrada $event
     * @return void
     */
    public function handle(BitacoraRegistrada $event)
    {
        $bitacora = new Bitacoras();
        $bitacora->bitacora = $event->mensaje;
        $bitacora->fecha = now()->toDateString();
        $bitacora->hora = now()->toTimeString();
        $bitacora->save();
    }
}
