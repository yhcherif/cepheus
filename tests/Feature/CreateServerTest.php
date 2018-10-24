<?php

namespace Tests\Feature;

use App\Event;
use Orus\Server;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateServerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_servers()
    {
        $this->get('/servers')->assertRedirect('/login');
        $this->post('/servers')->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_create_servers()
    {
        $this->withoutExceptionHandling();
        // Given an authenticated user
        $this->be(factory('Orus\User')->create());
        // When the user create a new server
        $data = factory('Orus\Server')->make(['ip_address' => '192.168.1.100'])->toArray();
        $this->post('servers', $data);
        // Then we should see evidence in database
        $this->assertDatabaseHas('servers', ['ip_address' => '192.168.1.100']);
    }

    /** @test */
    public function it_generate_a_cepheus_token_upone_server_registration()
    {
        $this->withoutExceptionHandling();
        // Given an authenticated user
        $this->be(factory('Orus\User')->create());
        // When the user create a new server
        $data = factory('Orus\Server')->make(['ip_address' => '192.168.1.100'])->toArray();
        $this->post('servers', $data);
        $server = Server::first();
        // Then we should see evidence in database
        $this->assertNotNull($server->token);
    }

    /** @test */
    public function a_server_requires_a_valid_name()
    {
        // Given an authenticated user
        $this->be(create('Orus\User'));
        // When the user create a new server
        $data = make('Orus\Server', ['name' => null])->toArray();
        $this->post('servers', $data)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_server_requires_a_valid_ip_address()
    {
        // Given an authenticated user
        $this->be(create('Orus\User'));
        // When the user create a new server
        $data = make('Orus\Server',['ip_address' => null])->toArray();
        $this->post('servers', $data)->assertSessionHasErrors('ip_address');

        $data['ip_address'] = 'foobar';
        $this->post('servers', $data)->assertSessionHasErrors('ip_address');

        $data = make('Orus\Server')->toArray();
        $this->post('servers', $data);
        $this->assertDatabaseHas("servers", ['ip_address' => $data['ip_address']]);
    }

    /** @test */
    public function a_provisioning_process_is_launched_upon_server_registration()
    {
        $this->withoutExceptionHandling();
        // Given an authenticated user
        $this->be(create('Orus\User'));
        // And a server
        $data = factory('Orus\Server')->make(['ip_address' => '192.168.1.100'])->toArray();
        // When the server is created
        $this->post('servers', $data);
        // Then the provisioning process script should be generated.
        $server = Server::first();
        $this->get("/servers/{$server->id}/vps?cepheus_token={$server->token}")->assertSee("Installation");
    }

    /** @test */
    public function it_updates_server_status_after_provisioning_process_succeded()
    {
        $this->withoutExceptionHandling();
        // Given an authenticated user
        $this->be(create('Orus\User'));
        // And a server
        $data = factory('Orus\Server')->make(['ip_address' => '192.168.1.100', 'ssh_port' => 4848])->toArray();
        // When the server is created
        $this->post('servers', $data);
        // Then the provisioning process script should be generated.
        $server = Server::first();
        $this->assertEquals($server->status, "provisioning");
        $this->get("/servers/{$server->id}/vps?cepheus_token={$server->token}")
        ->assertSee("Installation");
        $this->assertEquals($server->fresh()->status, "provisioning");
        $event = Event::first();
        $this->get(route('provisioning.store', ['server_id' => $server->id, 'event_id' => $event->id]));
        // dd(Event::all()->toArray());
        $this->assertEquals($server->fresh()->status, "active");
        $this->assertEquals($server->fresh()->active, 1);
    }
}
