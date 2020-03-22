<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use Illuminate\Http\Request;
use Validator;

class ClassController extends Controller
{
    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:classes,name',
                'code' => 'required|unique:classes,code',
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $clases = new Clas();
                $clases->name = $request->name;
                $clases->code = $request->code;
                if ($clases->save()) {
                    return response()->json($clases, 200);
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
            return Clas::all();
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:classes,name,' . $id,
                'code' => 'required|unique:classes,code,' . $id,
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $clas = Clas::find($id);
                $clas->name = $request->name;
                $clas->code = $request->code;
                if ($clas->update()) {
                    return response()->json($clas);
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
            if (Clas::destroy($id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
