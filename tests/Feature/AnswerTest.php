<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetQuestionAnswers()
    {
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $question= factory("App\Question")->create();
        $answers= factory("App\Answer",5)->create(["question_id"=>$question->id]);
        $response = $this->get("/questions/{$question->id}/answers");

        $response->assertStatus(200);

        $response->assertJson(["data"=>$answers->toArray()]);
    }

    public function testCreateNewAnswer(){
        $this->withoutExceptionHandling();
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $question = factory("App\Question")->create();
        $answer= factory("App\Answer")->raw(["question_id"=>""]);
        $response= $this->post("/questions/{$question->id}/answers",$answer);
        $response->assertStatus(201);
        $answer["question_id"]=$question->id;
        $this->assertDatabaseHas("answers",$answer);
        $response->assertJson($answer);
    }

    public function testAnswerRequired(){
        Passport::actingAs(factory("App\User")->create(),["*"]);
        $question= factory("App\Question")->create();
        $answer= factory("App\Answer")->raw(["question_id"=>"","answer"=>""]);
        $response= $this->post("/questions/{$question->id}/answers",$answer);
        $response->assertStatus(200);
        $response->assertJsonValidationErrors(["answer"]);
    }

    public function testUpdateAnswer(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $answer= factory("App\Answer")->create();
        $answer->answer="update answer";
        $response= $this->put("/answers/{$answer->id}",$answer->toArray());
        $response->assertStatus(200);
        $response->assertJson($answer->toArray());
        $this->assertDatabaseHas("answers",$answer->toArray());
    }

    public function testGetOneAnswer(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $answer= factory("App\Answer")->create();
        $response= $this->get("/answers/{$answer->id}");
        $response->assertStatus(200);
        $response->assertJson($answer->toArray());
    }

    public function testDeleteAnswer(){
        Passport::actingAs(
            factory("App\User")->create(),
            ['*']
        );
        $answer= factory("App\Answer")->create();

        $response= $this->delete("/answers/{$answer->id}");
        $response->assertStatus(200);
        $response->assertJson(["message"=>"Data Deleted Successfully!"]);
        $this->assertDatabaseMissing("answers",$answer->toArray());
    }
}
