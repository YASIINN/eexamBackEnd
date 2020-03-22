<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function school()
    {
        return $this->belongsToMany(School::class, "school_class_branch_pivots", "branch_id", "school_id");
    }
}
