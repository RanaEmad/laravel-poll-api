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

    public function testCreateNewPoll(){
        $poll= factory("App\Poll")->raw();
        $response = $this->post('/polls',$poll);
        $response->assertStatus(201);
        $response->assertJson($poll);
    }

    public function testGetOnePoll(){
        $poll= factory("App\Poll")->create();
        $response = $this->get("/polls/{$poll->id}");
        $response->assertStatus(200);
        $response->assertJson($poll->toArray());
    }

    public function testGetNonExistingPoll(){
        $response = $this->get("/polls/1");
        $response->assertStatus(404);
    }
}
