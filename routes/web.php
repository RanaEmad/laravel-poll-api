<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->resource('polls', 'PollController');

Route::middleware('auth:api')->resource('polls.questions', 'QuestionController')->shallow();

Route::middleware('auth:api')->resource("questions.answers","AnswerController")->shallow();
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
