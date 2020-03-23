<?php

namespace App\Http\Controllers;


use Validator;
use App\Models\ExamPartial;
use App\Models\ExamGroup;
use Illuminate\Http\Request;
use App\Models\Question;
class ExamGroupController extends Controller
{
    public function getPartialLists(Request $request){
        $partials = ExamPartial::with("chapter")->where("exam_id", $request->exam_id)->get();
        return $partials;
    }
    public function store(Request $request){
        $valid = Validator::make($request->all(), [
            'file_id' => 'required',
            'exam_id' => 'required',
            'group_id' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json(["message" => 'Eksik data gönderimi.'], 200);
        }
      try {
        $exampcheck = ExamGroup::where("exam_id", $request->exam_id)->where("group_id", $request->group_id)->get();
        if($exampcheck->count() > 0){
            return response()->json(["message" => 'Bu Kayıt Sistemde Mevcuttur.'], 200);
        }
        $examp = new ExamGroup();
        $examp->file_id = $request->file_id;
        $examp->exam_id = $request->exam_id;
        $examp->group_id = $request->group_id;
        if ($examp->save()) {
            for ($i=1; $i <= $request->qCount; $i++) { 
                $q= new Question();
                $q->qNo = $i;
                $q->exam_group_id = $examp->id;
                $q->save();
            }
            return response()->json($examp, 201);
        } else {
            return response()->json([], 500);
        }
      } catch (\Throwable $th) {
          return response()->json($th->getMessage());
      }
    }
    public function destroy($id)
    {
        try {
        $gr = ExamGroup::findOrFail($id);
        } catch(\Exception $exception){
            $errormsg = 'Veri Bulunamadı';
            return response()->json(['errormsg'=>$errormsg]);
        }
        $path = $gr->file->path;
        $dilimler = explode("storage/", $path);
        $dpath = 'app/public/'.$dilimler[1];
        if(file_exists(storage_path($dpath))) {
            $a = "var";
            unlink(storage_path($dpath));
        }
        if( $gr->file()->delete()){
            return response()->json(["message" =>'Veri başarıyla silindi.'], 200);
        }
    }

}