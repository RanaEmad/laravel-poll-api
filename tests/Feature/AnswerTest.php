<?php

namespace Tests\Feature;

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
        $question= factory("App\Question")->create();
        $answers= factory("App\Answer",5)->create(["question_id"=>$question->id]);
        $response = $this->get("/questions/{$question->id}/answers");

        $response->assertStatus(200);

        $response->assertJson($answers->toArray());
    }

    public function testCreateNewAnswer(){
        $this->withoutExceptionHandling();
        $question = factory("App\Question")->create();
        $answer= factory("App\Answer")->raw(["question_id"=>""]);
        $response= $this->post("/questions/{$question->id}/answers",$answer);
        $response->assertStatus(201);
        $answer["question_id"]=$question->id;
        $this->assertDatabaseHas("answers",$answer);
        $response->assertJson($answer);
    }

    public function testUpdateAnswer(){
        $answer= factory("App\Answer")->create();
        $answer->answer="update answer";
        $response= $this->put("/answers/{$answer->id}",$answer->toArray());
        $response->assertStatus(200);
        $response->assertJson($answer->toArray());
        $this->assertDatabaseHas("answers",$answer->toArray());
    }
}
