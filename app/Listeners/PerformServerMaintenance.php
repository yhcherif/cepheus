<?php

namespace App\Listeners;

use App\Event;
use Orus\Services\Nginx;
use App\Events\ServerWasProvisioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PerformServerMaintenance
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
        Nginx::on($event->server)->performMaintenance();
    }
}
