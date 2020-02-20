<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllPolls()
    {
        $polls= factory("App\Poll",5)->create();
        $response = $this->get('/polls');
        $response->assertStatus(200);
        $response->assertJson($polls->toArray());
    }
}
