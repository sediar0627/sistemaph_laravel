<?php

namespace App\Observers;

use App\Models\Piscina;
use Illuminate\Support\Str;

class PiscinaObserver
{
    /**
     * Handle the Elemento "creating" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function creating(Piscina $piscina)
    {
        $uuid = Str::uuid();
        while (Piscina::where("uuid", $uuid)->count() > 0) {
            $uuid = Str::uuid();
        }
        $piscina->uuid = $uuid;
    }

    /**
     * Handle the Piscina "created" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function created(Piscina $piscina)
    {
        //
    }

    /**
     * Handle the Piscina "updated" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function updated(Piscina $piscina)
    {
        //
    }

    /**
     * Handle the Piscina "deleted" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function deleted(Piscina $piscina)
    {
        //
    }

    /**
     * Handle the Piscina "restored" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function restored(Piscina $piscina)
    {
        //
    }

    /**
     * Handle the Piscina "force deleted" event.
     *
     * @param  \App\Models\Piscina  $piscina
     * @return void
     */
    public function forceDeleted(Piscina $piscina)
    {
        //
    }
}
