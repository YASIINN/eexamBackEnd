<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ExamController extends Controller
{
    public function store(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'optCount' => 'required',
            'qCount' => 'required',
            'beginHour' => 'required',
            'endHour' => 'required',
            'examDate' => 'required',
            'exam_type_id' => 'required',
            'lesson_id' => 'required',
            'school_id' => 'required',
            'class_id' => 'required',
            'branch_id' => 'required',
            'checkExam' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json(["message" => 'Eksik data gönderimi.'], 200);
        }

      try {
        $examcheck = Exam::where("checkExam", $request->checkExam)->get();
        if($examcheck->count() > 0){
            return response()->json(["message" => 'Bu Tarihte ilgili sınıfın sınavı mevcuttur.'], 200);
        }
        $exam = new Exam();
        $exam->name = $request->name;
        $exam->optCount = $request->optCount;
        $exam->qCount = $request->qCount;
        $exam->beginHour = $request->beginHour;
        $exam->endHour = $request->endHour;
        $exam->examDate = $request->examDate;
        $exam->exam_type_id = $request->exam_type_id;
        $exam->school_id = $request->school_id;
        $exam->class_id = $request->class_id;
        $exam->branch_id = $request->branch_id;
        $exam->lesson_id = $request->lesson_id;
        $exam->checkExam = $request->checkExam;
        if ($exam->save()) {
            return response()->json($exam, 201);
        } else {
            return response()->json([], 500);
        }
      } catch (\Throwable $th) {
          return response()->json($th->getMessage());
      }
    }
    public function index($id)
    {
        return Exam::with(["examgroup", 'examtype', 'school', 'lesson', 'class', 'branch', 'exampartial'])->where("id", $id)->get();
    }


    public function getStudentUnitExam(Request $request)
    {
        /*     try {

                 return response()->json($exams, 200);
             } catch (\Exception $e) {
                 return response()->json($e->getMessage(), 500);
             }*/
    }

    public function dateTimeControl(Request $request)
    {
        date_default_timezone_set('Europe/Istanbul');

        $examDateTime = Exam::find($request->id);

        $today = Carbon::now()->gte($examDateTime->examDate . " " . $examDateTime->beginHour);
        $todayEnd = Carbon::now()->lte($examDateTime->examDate . " " . $examDateTime->endHour);
        // bos ise saaat gelmedi
        // 1 ise vakit geldi geçti
        //false ise küçük şuan verilen saatten
        //true ise now 16:54 den küçük değil büyük o saat geçti ise
        //->format("Y-m-d H:i");
        /*        if ($today == "") {
                    return response()->json("Sınav Başlama Saati Henüz Gelmedi", 200);
                }
                if ($todayEnd == "") {
                    return response()->json("Sınav Bitiş Saati Dolmuştur Artık Sınava Girilemez", 200);
                }*/
        if ($today != 1) {
            return response()->json("Sınavın Başlama Saati Henüz Gelmedi", 200);
        }
        if ($todayEnd != 1) {
            return response()->json("Sınav Süresi Geçmiştir Sınava Girilemez", 200);
        }
        if ($today && $todayEnd) {
            $today = Carbon::now();
            $hour = $today->format("H:i:s");
            return response()->json(['time' => $hour], 200);
        }
    }

    public function getStudentExam(Request $request)
    {
        try {
            $exams = Exam::with(['examtype'])->where([
                ["school_id", "=", 3],
                ['class_id', '=', 4],
                ['examDate', "=", date("Y-m-d")]
            ])->whereHas("branch", function ($q) {
                $q->where([['name', '=', '-']]);
            })->whereHas("lesson", function ($q) {
                $q->where([['name', '=', '-']]);
            })->get();

            $unitexams = Exam::with(['examtype'])->where([
                ["school_id", "=", $request->schoolid],
                ['class_id', '=', $request->classid],
                ['branch_id', '=', $request->branchid],
                ['examDate', '=', date("Y-m-d")]
            ])->get();
            return response()->json(["exam" => $exams, "unitexam" => $unitexams], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
