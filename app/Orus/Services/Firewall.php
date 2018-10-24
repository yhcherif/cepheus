<?php
namespace Orus\Services;

use Orus\Services\Service;

class Firewall extends Service {

    protected $rules = [];

    public function allow($rules)
    {
        $this->script = "# Setup UFW Firewall\n";

        $rules = is_array($rules) ? $rules : [$rules];

        foreach ($rules as $key => $rule) {
            $this->script .= "ufw allow {$rule}";
        }

        $this->script = "ufw --force enable\n";

        return $this;
    }
}
