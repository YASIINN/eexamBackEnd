<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }
}
