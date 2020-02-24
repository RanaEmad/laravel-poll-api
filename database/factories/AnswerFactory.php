<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        "answer"=>$faker->paragraph,
        "question_id"=>function(){
            return factory("App\Question")->create();
        }
    ];
});
