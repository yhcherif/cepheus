<?php
namespace Orus\Services;

use Orus\Services\Service;

class Git extends Service {

    public function install()
    {
        $this->script = file_get_contents(app_path('Orus/Provision/stubs/git.stub'));
        $this->script = str_replace("{{USER_NAME}}", $this->server->owner->name, $this->script);
        $this->script = str_replace("{{USER_EMAIL}}", $this->server->owner->email, $this->script);

        return $this;
    }
}
