<?php
namespace Orus;

use Orus\Services\Service;

class System extends Service{

    public function initialize()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/initial.stub'));
        $this->script = str_replace("{{SERVER_NAME}}", $this->server->name, $this->script);
        $this->script = str_replace("{{SSH_PORT}}", $this->server->ssh_port, $this->script);
        $this->script = str_replace("{{ROOT_PASSWORD}}", $this->server->sudo_password, $this->script);

        return $this;
    }

    public function homePermissions()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/permissions.stub'));

        return $this;
    }
}
