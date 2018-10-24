<?php
namespace Orus\Services;

use Orus\Cepheus\Cepheus;
use Orus\Services\Service;

class SSH extends Service {

    protected $name = 'ssh';

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/ssh.stub'));
        $this->script = str_replace("{{SSH_PORT}}", $this->server->ssh_port, $this->script);
        $this->script = str_replace(
            "{{SSH_PUB_KEY}}",
            Cepheus::publicKey(),
            $this->script
        );

        return $this;
    }
}
