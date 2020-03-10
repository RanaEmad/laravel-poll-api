<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return response()->json($question->answers()->paginate(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($question_id,Request $request)
    {
        $attributes= [
            "answer"=>$request->answer
        ];
        $validator= $this->validateData($attributes);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        $attributes["question_id"]=$question_id;
        return response()->json(Answer::create($attributes),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return response()->json($answer->toArray(),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        $attributes= [
            "answer"=>$request->answer
        ];
        $validator= $this->validateData($attributes);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        $answer->answer= $attributes["answer"];
        $answer->save();
        return response()->json($answer->toArray(),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return response()->json(["message"=>"Data Deleted Successfully!"],200);
    }

    protected function validateData($data){
        $validator= Validator::make($data,[
            "answer"=>"required"
        ]);
        return $validator;
    }
}
