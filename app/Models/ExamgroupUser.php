<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamgroupUser extends Model
{
  protected $table = "examgroup_user";
    public function examgroup()
    {
        return $this->belongsTo(ExamGroup::class, "group_id", "id");
    }
}
