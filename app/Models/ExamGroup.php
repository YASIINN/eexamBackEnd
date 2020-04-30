<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamGroup extends Model
{
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public  function examgroupuser(){
        return $this->belongsToMany(User::class, "examgroup_user", "exam_group_id", "user_id");

    }

    public function groups()
    {
        return $this->belongsTo(Group::class, "group_id", "id");
    }

    public  function  question(){
        return $this->hasMany(Question::class,"exam_group_id","id");


    }
    public  function examcontent(){
        return $this->hasMany(ExamContent::class,"exam_group_id","id")->with(['questions']);

    }

    public  function files(){
        return $this->belongsTo(File::class, "file_id", "id");
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }


    //adem
    public  function contents(){
        return $this->hasMany(ExamContent::class,"exam_group_id","id")->with(['question', "option", "user"]);
    }
    public  function users(){
        return $this->belongsToMany(User::class, "examgroup_user", "exam_group_id", "user_id");
    }
    //adem
}
