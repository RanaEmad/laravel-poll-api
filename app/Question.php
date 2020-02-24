<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=["title","question","poll_id"];

    public function poll(){
        return $this->belongsTo('App\Poll');
    }
}
