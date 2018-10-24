<?php
namespace Orus\Services;

use Symfony\Component\Process\Process;

class Service {

    protected $user = 'cepheus';
    protected $event;

    protected $server;

    protected $name = "";

    protected $script = '';

    public function __construct($server)
    {
        $this->server = $server;
    }

    public static function on($server)
    {
        return new static($server);
    }

    public function raw()
    {
        return $this->script;
    }

    public function asSudo()
    {
        $this->user = 'root';

        return $this;
    }

    public function runAsRoot()
    {
        $user = "root";
        $script_filename = "provision-{$this->event->id}.sh";
        $script_output = "provision-{$this->event->id}.output";

        $tmp_file = storage_path($script_filename);
        $remote_user_script_path = "/root/.cepheus/{$script_filename}";
        $remote_user_script_output_path = "/root/.cepheus/{$script_output}";

        file_put_contents($tmp_file, $this->raw());

        $command = "scp {$tmp_file} {$user}@{$this->server->ip_address}:{$remote_user_script_path} && ";
        $command .= "ssh {$user}@{$this->server->ip_address} 'bash {$remote_user_script_path} > {$remote_user_script_output_path} 2>&1'";

        $process = new Process($command);

        try {
            $process->run();
            $this->event->status = "completed";
            $this->event->output = $process->getOutput();
            $this->event->completed_at = now();
            $this->event->save();

            return true;
        } catch (\Exception $e) {
            $this->event->output = $process->getErrorOutput();
            dump($process->getErrorOutput());
            return false;
            // $this->event->status = "failed";
        }

        // // executes after the command finishes
        // if (!$process->isSuccessful()) {
        //     $this->event->status = "failed";
        //     // throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        // }
    }

    public function run()
    {
    }

    public function install()
    {
    }

    public function __get($key)
    {
        if ( array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return $this->{$key};
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->attributes)) {
            $this->attributes[$key] = $value;
            return;
        }

        $this->{$key} = $value;
    }

    public function __call($name, $arguments)
    {
        return $this->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return (new static)->{$name}(...$arguments);
    }
}
