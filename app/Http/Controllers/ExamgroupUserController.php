<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamgroupUser;
use Validator;

class ExamgroupUserController extends Controller
{
    public function store(Request $request){
      try {
          foreach ($request->all() as $key => $r) {
              $egus = ExamgroupUser::where("user_id", $r["user_id"])->first();
              if($egus === null){
                $egu = new ExamgroupUser();
                $egu->user_id = $r["user_id"];
                $egu->exam_group_id = $r["exam_group_id"];
                $egu->save();
              } else {
                $egus->user_id = $r["user_id"];
                $egus->exam_group_id = $r["exam_group_id"];
                $egus->save();
              }
          }
          return response()->json(["message"=>"Öğrenci grup ataması başarıyla gerçekleştirildi."],201);
      } catch (\Throwable $th) {
          return response()->json($th->getMessage());
      }
    }
}
