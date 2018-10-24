<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->servers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'ip_address' => 'required|ip|unique:servers,ip_address',
            'ram_size'  => 'required|integer',
            'ssh_port'  => 'required',
            // 'database_root_password' => 'min:10',
        ]);
        $server = auth()->user()->addServer($data);

        return response()->json([
            'provisioning_link' => "wget -O cepheus.sh " . route('provisioning.create', ['server' => $server, 'cepheus_token' => $server->token]) . "; bash cepheus.sh",
            'database_password' => $server->database_root_password,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function events()
    {
        $servers = auth()->user()->servers->pluck('id');

        return Event::with('server')
        ->where("status", 'completed')
        ->whereIn('server_id', $servers)
        ->orderBy("completed_at", "DESC")
        ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
