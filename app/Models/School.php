<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function clases()
    {
        return $this->belongsToMany(Clas::class, "school_class_branch_pivots", "school_id", "class_id")->with("branches");
    }

    public function user()
    {
        return $this->hasMany(User::class,"school_id","id");
    }

    public function branch()
    {
        return $this->belongsToMany(Branch::class, "school_class_branch_pivots", "school_id", "branch_id");
    }
    //adem
    public function classes()
    {
        return $this->belongsToMany(Clas::class, "school_class_branch_pivots", "school_id", "class_id")->with("branches");
    }
    //adem
}
