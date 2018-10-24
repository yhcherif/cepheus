<?php
namespace Orus\Services;

use Orus\Services\Service;

class Redis extends Service{

    protected $name = "redis-server";

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/redis.stub'));

        return $this;
    }
}
