<?php
namespace Orus\Services;

use Orus\Services\Service;

class MySQL extends Service{

    protected $name = "mysql";

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/mysql.stub'));
        $this->script = str_replace("{{DB_ROOT_PASSWORD}}", $this->server->database_root_password ?? 'cepheus', $this->script);

        return $this;
    }
}
