<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        "title"=>$faker->realText(50),
        "question"=>$faker->paragraph,
        "poll_id"=>function(){
            $poll = factory("App\Poll")->create();
            return $poll;
        }
    ];
});
