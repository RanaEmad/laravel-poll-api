<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPollQuestions()
    {
        $poll= \factory("App\Poll")->create();
        $questions= \factory("App\Question",5)->create(["poll_id"=>$poll->id]);
        $response = $this->get("/polls/{$poll->id}/questions");

        $response->assertStatus(200);
        $response->assertJson($questions->toArray());
    }

    public function testCreateNewQuestion(){
        // $this->withoutExceptionHandling();
        $poll= \factory("App\Poll")->create();
        $question= \factory("App\Question")->raw(["poll_id"=>""]);
        $response=$this->post("/polls/{$poll->id}/questions",$question);
        $response->assertStatus(201);
        $question["poll_id"]=$poll->id;
        $response->assertJson($question);
    }

    public function testCreateNewQuestionToNonExistingPoll(){
        // $this->withoutExceptionHandling();
        $question= \factory("App\Question")->raw(["poll_id"=>""]);
        $response=$this->post("/polls/1400/questions",$question);
        $response->assertStatus(404);
    }

    public function testUpdateQuestion(){
         $this->withoutExceptionHandling();
        $question= \factory("App\Question")->create();
        $question->title= "updated title";
        $response=$this->put("/questions/{$question->id}",$question->toArray());
        $response->assertStatus(200);
        $response->assertJson($question->toArray());
    }
}
