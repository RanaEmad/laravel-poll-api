<?php

namespace App\Http\Controllers;

use App\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Poll::paginate()->all(),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['title']=$request->title;
        $validator=$this->validateData($data);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        return response()->json(Poll::create($request->all()),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        return response()->json($poll,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        $data['title']=$request->title;
        $validator=$this->validateData($data);
        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()],200);
        }
        $poll->title= $request->title;
        $poll->save();
        return response()->json($poll,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        $poll->delete();
        return response()->json(["message"=>"Data Deleted Successfully!"],200);
    }

    protected function validateData($data){
        $validator= Validator::make($data,["title"=>"required|max:50"]);
         return $validator;
    }
}
