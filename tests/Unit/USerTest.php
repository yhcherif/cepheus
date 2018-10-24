<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class USerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('Orus\User');
    }

    /** @test */
    public function it_has_many_servers()
    {
        $this->assertInstanceOf("Illuminate\Support\Collection", $this->user->servers);
    }

    /** @test */
    public function it_can_add_a_new_server_to_its_servers_list()
    {

        $this->assertCount(0, $this->user->servers);
        $data = [
            'name' => 'foobar',
            'ip_address' => '10.10.10.10',
        ];
        $this->user->addServer($data);
        $this->assertCount(1, $this->user->fresh()->servers);
    }
}
