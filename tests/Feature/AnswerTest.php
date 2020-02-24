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
    
}