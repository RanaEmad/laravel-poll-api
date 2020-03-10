<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        "title"=>$faker->text(20),
        "question"=>$faker->text(50),
        "poll_id"=>function(){
            $poll = factory("App\Poll")->create();
            return $poll;
        }
    ];
});
