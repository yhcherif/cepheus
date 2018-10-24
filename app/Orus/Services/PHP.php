<?php
namespace Orus\Services;

use Orus\Services\Service;

class PHP extends Service{

    protected $name = "php7.2";

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/'. $this->name .'.stub'));

        return $this;
    }
}
