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
}
