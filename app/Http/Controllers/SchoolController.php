<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClassBranchPivot;
use Illuminate\Http\Request;
use App\Models\Clas;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Validator;

class SchoolController extends Controller
{

    public function delSCB(Request $request)
    {
        try {
            $valid = Validator::make($request->all(), [
                'schoolid' => 'required',
                'branchid' => 'required',
                'classid' => 'required',

            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 400);
            } else {
                if (SchoolClassBranchPivot::where(
                    [
                        ["school_id", "=", $request->schoolid],
                        ["class_id", "=", $request->classid],
                        ["branch_id", "=", $request->branchid],
                    ]
                )->delete()) {
                    return response()->json("Success", 200);

                }
            }
        } catch (\Exception $e) {
            return response()->json($e, 500);

        }
    }

    public function addSCB(Request $request)
    {
        try {
            $valid = Validator::make($request->all(), [
                'scblist' => 'required',

            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 400);
            } else {
                $saved = false;
                foreach ($request->scblist as $item) {
                    $scb = new SchoolClassBranchPivot();
                    $sbcHave = SchoolClassBranchPivot::where(
                        [
                            ["school_id", "=", $item['schoolid']],
                            ["class_id", "=", $item['classid']],
                            ["branch_id", "=", $item['branchid']],

                        ]
                    )->get();
                    if (count($sbcHave) > 0) {
                        $saved = true;

                    } else {
                        $saved = true;
                        $scb->school_id = $item['schoolid'];
                        $scb->class_id = $item['classid'];
                        $scb->branch_id = $item['branchid'];
                        if ($scb->save()) {
                            $saved = true;

                        } else {
                            return response()->json("Error", 500);

                        }
                    }
                }
                if ($saved) {
                    return response()->json("Success", 200);
                }
            }

        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function getSCB(Request $request)
    {
        try {


//    $schools = School::with(['classes'])->where("id",$request->schoolid)->has("classes")->get();
//         $scb = [];
//         foreach ($schools as $key => $school) {
//             $collection = collect($school->classes);
//             $unique = $collection->unique('id');
//             unset($school["classes"]);
//             $school["classes"] = $unique->values()->all();
//             foreach ($unique->values()->all() as $key => $class) {
//                 $collectionclass = collect($class->branches);
//                 $uniqueclass = $collectionclass->unique('id');
//                 unset($class["branches"]);
//                 $class["branches"] = $uniqueclass->values()->all();
//             }
//             array_push($scb, $school);
//         }
//         return $scb;


            $data = DB::table('school_class_branch_pivots')
                ->join('schools', 'schools.id', '=', 'school_class_branch_pivots.school_id')
                ->join('classes', 'classes.id', '=', 'school_class_branch_pivots.class_id')
                ->join('branches', 'branches.id', '=', 'school_class_branch_pivots.branch_id')
                ->select("school_class_branch_pivots.*", "schools.*", "classes.*", "branches.*")
                ->where([
                    ['schools.id', '=', $request->schoolid],
                ])
                ->get();
            $result = [];
            foreach ($data as $key => $item) {
                $schooldata = School::find($item->school_id);
                $classdata = Clas::find($item->class_id);
                $branchdata = Branch::find($item->branch_id);
                array_push($result, [
                    "schoolid" => $item->school_id,
                    "classid" => $item->class_id,
                    "branchid" => $item->branch_id,
                    "schoolname" => $schooldata->name,
                    "branchname" => $branchdata->name,
                    "classname" => $classdata->name,
                    "fullname"=>$classdata->name. " ".$branchdata->name

                ]);

                # code...
            }
            // return $data;
            return $result;
            $scb = School::with(['clases'])->where("id", $request->schoolid)->has("clases")->get();
            if (count($scb) > 0) {
                return response()->json($scb, 200);
            } else {
                return response()->json([], 204);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:schools,name',
                'code' => 'required|unique:schools,code',
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $school = new School();
                $school->name = $request->name;
                $school->code = $request->code;
                if ($school->save()) {
                    return response()->json($school, 200);
                } else {
                    return response()->json([], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function index(Request $request)
    {
        try {
            return School::where([
                ['name', "!=", '-']
            ])->get();
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:schools,name,' . $id,
                'code' => 'required|unique:schools,code,' . $id,
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $school = School::find($id);
                $school->name = $request->name;
                $school->code = $request->code;
                if ($school->update()) {
                    return response()->json($school);
                } else {
                    return response()->json([], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (School::destroy($id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
