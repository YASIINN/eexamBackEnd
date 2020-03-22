<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamContent extends Model
{
    public  function  questions(){
        return $this->belongsTo(Question::class, "question_id", "id");
    }

}
