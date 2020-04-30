<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Validator;

class LessonController extends Controller
{

    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:lessons,name',
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $lesson = new Lesson();
                $lesson->name = $request->name;
                if ($lesson->save()) {
                    return response()->json($lesson, 200);
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
            return Lesson::all();
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:lessons,name,' . $id,
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $lesson = Lesson::find($id);
                $lesson->name = $request->name;
                if ($lesson->update()) {
                    return response()->json($lesson);
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
            if (Lesson::destroy($id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
