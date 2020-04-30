<?php

namespace App\Http\Controllers;
use Storage;
use Carbon\Carbon;
use App\Models\School;
use App\Models\Branch;
use Illuminate\Http\Request;

class SchoolClassBranchPivotController extends Controller
{
    public function index(){
        $schools = School::with(['classes'])->has("classes")->get();
        $scb = [];
        foreach ($schools as $key => $school) {
            $collection = collect($school->classes);
            $unique = $collection->unique('id');
            unset($school["classes"]);
            $school["classes"] = $unique->values()->all();
            foreach ($unique->values()->all() as $key => $class) {
                $collectionclass = collect($class->branches);
                $uniqueclass = $collectionclass->unique('id');
                unset($class["branches"]);
                $class["branches"] = $uniqueclass->values()->all();
            }
            array_push($scb, $school);
        }
        return $scb;
    }
}
