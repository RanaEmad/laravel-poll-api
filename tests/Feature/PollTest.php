<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PollTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllPolls()
    {
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $polls= factory("App\Poll",5)->create();
        $response = $this->get('/polls');
        $response->assertStatus(200);
        $response->assertJson($polls->toArray());
    }

    public function testCreateNewPoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $poll= factory("App\Poll")->raw();
        $response = $this->post('/polls',$poll);
        $response->assertStatus(201);
        $response->assertJson($poll);
    }

    public function testTitleRequired(){
        // $this->withoutExceptionHandling();
        Passport::actingAs(factory("App\User")->create(),["*"]);

        $poll= factory("App\Poll")->raw(["title"=>""]);
        $response= $this->post("/polls",$poll);
        $response->assertStatus(200);
        $response->assertJsonValidationErrors(["title"]);
    }

    public function testTitleMaxLength(){
        // $this->withoutExceptionHandling();
        Passport::actingAs(factory("App\User")->create(),["*"]);

        $poll= factory("App\Poll")->raw(["title"=>$this->faker->realText(55)]);
        $response= $this->post("/polls",$poll);
        $response->assertStatus(200);
        $response->assertJsonValidationErrors(["title"]);
    }

    public function testGetOnePoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $poll= factory("App\Poll")->create();
        $response = $this->get("/polls/{$poll->id}");
        $response->assertStatus(200);
        $response->assertJson($poll->toArray());
    }

    public function testGetNonExistingPoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $response = $this->get("/polls/1");
        $response->assertStatus(404);
    }

    public function testUpdatePoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $poll= factory("App\Poll")->create();
        $newTitle="test poll update";
        $response= $this->put("/polls/{$poll->id}",["title"=>$newTitle]);
        $poll->title=$newTitle;
        $response->assertStatus(200);
        $response->assertJson($poll->toArray());
    }

    public function testUpdateNonExistingPoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $newTitle="test poll update";
        $response= $this->put("/polls/1000",["title"=>$newTitle]);
        $response->assertStatus(404);
    }

    public function testDeletePoll(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $poll= factory("App\Poll")->create();
        $response= $this->delete("/polls/{$poll->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing("polls",$poll->toArray());
        $response->assertJson(["message"=>"Data Deleted Successfully!"]);
    }

}
