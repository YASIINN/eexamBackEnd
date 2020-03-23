<?php

namespace App\Http\Controllers;


use Validator;
use App\Models\ExamPartial;
use Illuminate\Http\Request;

class ExamPartialController extends Controller
{
    public function getPartialLists(Request $request){
        $partials = ExamPartial::with("chapter")->where("exam_id", $request->exam_id)->get();
        return $partials;
    }
    public function store(Request $request){
        $valid = Validator::make($request->all(), [
            'startQ' => 'required',
            'endQ' => 'required',
            'exam_id' => 'required',
            'chapter_id' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json(["message" => 'Eksik data gönderimi.'], 200);
        }
      try {
        $exampcheck = ExamPartial::where("exam_id", $request->exam_id)->where("chapter_id", $request->chapter_id)->get();
        if($exampcheck->count() > 0){
            return response()->json(["message" => 'Bu Kayıt Sistemde Mevcuttur.'], 200);
        }
        $examp = new ExamPartial();
        $examp->startQ = $request->startQ;
        $examp->endQ = $request->endQ;
        $examp->exam_id = $request->exam_id;
        $examp->chapter_id = $request->chapter_id;
        if ($examp->save()) {
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
        $apd = ExamPartial::findOrFail($id);
        } catch(\Exception $exception){
            $errormsg = 'Veri Bulunamadı';
            $hata = $exception->getMessage();
            return response()->json(['errormsg'=>$errormsg]);
        }
        if($apd->delete()){
            return response()->json(["message" =>'Veri başarıyla silindi.'], 200);
        }
    }

}