<?php

namespace App\Http\Controllers;

use App\Question;
use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Poll $poll)
    {
        return response()->json($poll->questions()->paginate(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Poll $poll,Request $request)
    {
        $attributes=[
            "title"=>$request->title,
            "question"=>$request->question
        ];
        $validator= $this->validateData($attributes);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        $attributes["poll_id"]=$poll->id;
        return response()->json(Question::create($attributes),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return response()->json($question->toArray(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $attributes=[
            "title"=>$request->title,
            "question"=>$request->question
        ];
        $validator= $this->validateData($attributes);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        $question->title=$attributes["title"];
        $question->question=$attributes["question"];
        $question->save();
        return response()->json($question->toArray(),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(["message"=>"Data Deleted Successfully!"]);
    }

    protected function validateData($data){
        $validator= Validator::make($data,[
            "title"=>"required|max:50",
            "question"=>"required|max:250"
        ]);
        return $validator;
    }
}
