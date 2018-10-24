<?php
namespace Orus\Services;

use App\Event;
use Orus\Services\Service;

class Nginx extends Service{

    protected $name = "nginx";

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/nginx.stub'));

        return $this;
    }

    public function performMaintenance()
    {
        $process = $this->maintenance();
        $this->event = Event::create([
            'name' =>  "Performing Cepheus Nginx Maintenance.",
            'server_id' => $this->server->id,
            'script' => $process->raw(),
            'status' => 'pending'
        ]);
        $process->runAsRoot();
    }

    public function maintenance()
    {
        $this->script = "echo DUMMY";

        return $this;
    }
}
