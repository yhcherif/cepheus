<?php

namespace Orus;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Retrieve all servers created by the current user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function servers()
    {
        return $this->hasMany(Server::class);
    }

    /**
     * Add a new server to the user's servers.
     *
     * @param array $data
     * @return Server
     */
    public function addServer($data)
    {
        $data['sudo_password'] = str_random(30);
        $data['token'] = str_random(70);
        return $this->servers()->create($data);
    }
}
