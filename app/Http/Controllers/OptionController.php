<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Validator;

class OptionController extends Controller
{
    public function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:options,name',
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $opt = new Option();
                $opt->name = $request->name;
                if ($opt->save()) {
                    return response()->json($opt, 200);
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
            return Option::where([['name','!=','-']])->get();
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required|unique:options,name,' . $id,
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $opt = Option::find($id);
                $opt->name = $request->name;
                if ($opt->update()) {
                    return response()->json($opt);
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
            if (Option::destroy($id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
}
