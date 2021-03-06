<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    public function school()
    {
        return $this->belongsTo(School::class, "school_id", "id");
    }
 

    public function examgroupuser()
    {
        return $this->belongsToMany(ExamGroup::class,
            "examgroup_user",
            "user_id",
            "exam_group_id")
            ->with(['file', 'groups', 'question', 'examcontent', 'exam', 'exam.examtype', 'exam.school', 'exam.lesson', 'exam.class', 'exam.branch', 'exam.exampartial']);

    }

    public function class()
    {
        return $this->belongsTo(Clas::class, "class_id", "id");
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, "branch_id", "id");
    }
    // public function userexamgroups(){
    //     return $this->belongsToMany(examgroup::class, "examgroup_user");
    // }
    // public function examgroup(){
    //     return $this->belongsToMany(ExamGroup::class, "examgroup_user");
    // }
    public function examgroups()
    {
        return $this->belongsToMany(ExamGroup::class,
            "examgroup_user",
            "user_id",
            "exam_group_id")->with("contents");
    }
    public function contents(){
        return $this->belongsToMany(ExamGroup::class,
        "exam_contents",
        "user_id",
        "exam_group_id");
    }
    public function examcontents(){
        return $this->hasMany(ExamContent::class, "user_id", "id")->with(["question", "option", "exam_group"]);
    }
}
