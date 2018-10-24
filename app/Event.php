<?php

namespace App;

use Orus\Server;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['server_id', 'name', 'status', 'script', 'output', 'completed_at'];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
