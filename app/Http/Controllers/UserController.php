<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use ReallySimpleJWT\Token;
use Storage;
use Validator;


class UserController extends Controller
{

    public function login(Request $request)
    {
        try {


            $valid = Validator::make($request->all(), [
                'tc' => 'required',
                'password' => 'required',

            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {


                $user = User::where([
                    ['tc', '=', $request->tc],
                    ['password', '=', $request->password],

                ])->get();
                if (count($user) > 0) {
                    $token_payload = [
                        'id' => $user[0]->id,
                        'tc' => $user[0]->tc,
                        'fullname' => $user[0]->fullname,
                    ];
                    $secret = env('JWT_SECRET');
                    $token = Token::customPayload($token_payload, $secret);

                    return response()->json(["user" => $user[0], "token" => $token], 200);
                } else {
                    return response()->json([], 204);

                }
            }
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (User::destroy($id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function index()
    {
        try {
            return User::with(['school', 'class', 'branch'])->where(
                [
                    ['status', '=', 0],
                    ['type', '=', 0],
                ]
            )->latest()->paginate(10);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required',
                'surname' => 'required',
                'tc' => 'required|unique:users,tc,' . $id,
                'schoolno' => 'required|unique:users,schoolNo,' . $id,
                'email' => 'required|unique:users,email,' . $id,
                'schoolid' => 'required',
                'clasid' => 'required',
                'branchid' => 'required',
            ]);
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $student = User::find($id);
                $student->name = $request->name;
                $student->surname = $request->surname;
                $student->fullname = $request->name . " " . $request->surname;
                $student->tc = $request->tc;
                $student->schoolNo = $request->schoolno;
                $student->status = $request->status;
                $student->type = $request->type;
                $student->email = $request->email;
                $student->school_id = $request->schoolid;
                $student->class_id = $request->clasid;
                $student->branch_id = $request->branchid;
                $student->password = "Zafer*123";
                if ($student->update()) {
                    return response()->json($student, 200);
                } else {

                }
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public
    function store(Request $request)
    {

        try {
            $valid = Validator::make($request->all(), [
                'name' => 'required',
                'surname' => 'required',
                'tc' => 'required|unique:users,tc',
                'schoolno' => 'required|unique:users,schoolNo',
                'email' => 'required|unique:users,email',
                'schoolid' => 'required',
                'clasid' => 'required',
                'branchid' => 'required',

            ]);
            //status ve type eklenebilir
            if ($valid->fails()) {
                return response()->json(['error' => $valid->errors()], 204);
            } else {
                $student = new User();
                $student->name = $request->name;
                $student->surname = $request->surname;
                $student->fullname = $request->name . " " . $request->surname;
                $student->tc = $request->tc;
                $student->schoolNo = $request->schoolno;
                $student->status = $request->status;
                $student->type = $request->type;
                $student->email = $request->email;
                $student->school_id = $request->schoolid;
                $student->class_id = $request->clasid;
                $student->branch_id = $request->branchid;
                $student->password = "Zafer*123";
                //default parola
                // 0 öğrenci 1 personel

                if ($student->save()) {
                    return response()->json($student, 200);
                } else {
                    return response()->json([], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }


}
