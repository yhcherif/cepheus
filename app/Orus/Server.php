<?php

namespace Orus;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'ip_address', 'ram_size', 'sudo_password', 'ssh_key', 'token', 'ssh_port', 'database_root_password', 'type', 'status', 'active', 'server_type'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wants($type)
    {
        return $this->server_type == $type;
    }
}
