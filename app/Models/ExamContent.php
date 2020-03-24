<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamContent extends Model
{
    public  function  questions(){
        return $this->belongsTo(Question::class, "question_id", "id");
    }
    
    //adem
    public  function user(){
        return $this->belongsTo(User::class);
    }
    public  function question(){
        return $this->belongsTo(Question::class);
    }
    public  function option(){
        return $this->belongsTo(Option::class);
    }
    //ademm


}
