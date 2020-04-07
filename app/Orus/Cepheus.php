<?php
namespace Orus\Cepheus;

use App\Event;
use Orus\System;
use Orus\Services\Git;
use Orus\Services\PHP;
use Orus\Services\SSH;
use Orus\Services\MySQL;
use Orus\Services\Nginx;
use Orus\Services\Redis;
use Orus\Services\Firewall;

class Cepheus {
    protected $server;

    protected $script = '';

    public function __construct($server)
    {
        $this->server = $server;
    }

    public static function provision($server)
    {
        return (new static($server))->generateScript();
    }

    public function generateScript()
    {
        // $this->initialize();
        // $this->buildSSHKeys();
        // $this->initializeGit();
        // $this->fixHomePermissions();
        // $this->applySecurityRules();
        // $this->setupPHP();
        // $this->setupWebServer();
        // $this->installMysql();
        // $this->installRedisServer();
        // $this->appendCallbackUrl();
        //
        ob_start();
        echo System::on($this->server)->initialize()->raw();
        echo SSH::on($this->server)->install()->raw();
        echo Git::on($this->server)->install()->raw();
        echo System::on($this->server)->homePermissions()->raw();
        echo Firewall::on($this->server)->allow($this->server->ssh_port)->raw();
        if($this->server->wants("web")){
            echo PHP::on($this->server)->install()->raw();
            echo Nginx::on($this->server)->install()->raw();
            echo MySQL::on($this->server)->install()->raw();
            echo Redis::on($this->server)->install()->raw();
        }
        $this->script = ob_get_contents();
        ob_end_clean();
        $this->appendCallbackUrl();
        // $this->script .= setupPHP();
        // $this->script .= setupWebServer();
        // $this->script .= installMysql();
        // $this->script .= installRedisServer();
        // $this->script .= appendCallbackUrl();
        return $this->script;
    }

    public function initialize()
    {
        $output = file_get_contents(app_path('Orus/Provision/stubs/initial.stub'));
        $output = str_replace("{{SERVER_NAME}}", $this->server->name, $output);
        $output = str_replace("{{SSH_PORT}}", $this->server->ssh_port, $output);
        $output = str_replace("{{ROOT_PASSWORD}}", $this->server->sudo_password, $output);

        $this->script .= $output;

        return $this;
    }

    protected function buildSSHKeys()
    {
        $output = file_get_contents(app_path('Orus/Provision/stubs/ssh.stub'));
        $output = str_replace("{{SSH_PORT}}", $this->server->ssh_port, $output);
        $this->script .= str_replace(
            "{{SSH_PUB_KEY}}",
            $this->sshPublicKey(),
            $output
        );

        return $this;
    }

    public static function publicKey()
    {
        // if (in_array(env('APP_ENV'), ['local', 'testing'])) {
        //     return file_get_contents(home_directory('/.ssh/id_rsa.pub'));
        // }
        if (!file_exists(home_directory('/.ssh/id_rsa.pub'))) {
            system("ssh-keygen -f /.ssh/id_rsa -t rsa -N ''");
        }

        return file_get_contents(home_directory('/.ssh/id_rsa.pub'));
    }

    protected function sshPublicKey()
    {
        // if (in_array(env('APP_ENV'), ['local', 'testing'])) {
        //     return file_get_contents(home_directory('/.ssh/id_rsa.pub'));
        // }
        if (!file_exists(home_directory('/.ssh/id_rsa.pub'))) {
            system("ssh-keygen -f /.ssh/id_rsa -t rsa -N ''");
        }

        return file_get_contents(home_directory('/.ssh/id_rsa.pub'));
    }

    protected function initializeGit()
    {
        $output = file_get_contents(app_path('Orus/Provision/stubs/git.stub'));
        $output = str_replace("{{USER_NAME}}", $this->server->owner->name, $output);
        $this->script .= str_replace("{{USER_EMAIL}}", $this->server->owner->email, $output);

        return $this;
    }

    protected function fixHomePermissions()
    {
        $this->script .= file_get_contents(app_path('Orus/Provision/stubs/permissions.stub'));

        return $this;
    }

    protected function applySecurityRules()
    {
        $output = file_get_contents(app_path('Orus/Provision/stubs/firewall.stub'));
        $this->script .= str_replace("{{SSH_PORT}}", $this->server->ssh_port, $output);

        return $this;
    }

    public function setupPHP()
    {
        $this->script .= file_get_contents(app_path('Orus/Provision/stubs/php.stub'));
        // $output = str_replace("{{SSH_PORT}}", $this->ssh_port, $output);

        return $this;
    }

    public function setupWebServer()
    {
        $this->script .= file_get_contents(app_path('Orus/Provision/stubs/web-server.stub'));
        // $output = str_replace("{{SSH_PORT}}", $this->ssh_port, $output);

        return $this;
    }

    public function installMysql()
    {
        $output = file_get_contents(app_path('Orus/Provision/stubs/mysql.stub'));
        $this->script .= str_replace("{{DB_ROOT_PASSWORD}}", $this->database_root_password ?? 'cepheus', $output);

        return $this;
    }

    public function installRedisServer()
    {
        $this->script .= file_get_contents(app_path('Orus/Provision/stubs/redis.stub'));
        // $output = str_replace("{{DB_ROOT_PASSWORD}}", $this->database_root_password ?? 'cepheus', $output);

        return $this;
    }


    protected function appendCallbackUrl()
    {
        $event = Event::create([
            'server_id' => $this->server->id,
            'name' => 'Provisioning New Server',
            'script' => $this->script,
        ]);

        $this->script .= "\n# notify cepheus\ncurl --insecure --data \"event_id=". $event->id ."&server_id=". $this->server->id ."&sudo_password=KuXxrWIPIeFhwLnXA5fe&db_password=VxXEzoyNyvre3ssaEa9j&recipe_id=\" ". route('provisioning.store', [
            'server_id' => $this->server->id,
            "event_id" => $event->id,
        ]) . "\n";

        $event->update(['script' => $this->script]);

        return $this;
    }
}
