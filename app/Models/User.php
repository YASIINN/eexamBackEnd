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

    public function class()
    {
        return $this->belongsTo(Clas::class, "class_id", "id");
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, "branch_id", "id");
    }
}
