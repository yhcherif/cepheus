<?php

namespace App\Listeners;

use App\Events\ServerWasProvisioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddScheduledJobForComposerUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ServerWasProvisioned  $event
     * @return void
     */
    public function handle(ServerWasProvisioned $event)
    {
        //
    }
}
