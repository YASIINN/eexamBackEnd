<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamContent;
use App\Models\ExamGroup;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class ExamController extends Controller
{
    public function getExams(Request $request)
    {
        if ($request->detailSearch) {
            return Exam::with(["examtype", "school", "class", "branch", "lesson", "groups", "partials", "files"])
                ->has("examgroups.examcontent")->paginate(5);
        } else {
            $exams = Exam::with(["examtype", "school", "class", "branch", "lesson", "groups", "partials", "files"])
                ->doesntHave("examgroups.examcontent")
                ->paginate(5);
            return $exams;
        }

    }

    public function destroy($id)
    {
        try {
            if (Exam::doesntHave("examgroups.examcontent")->where("id", $id)->delete()) {
                return response()->json('Success', 200);
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }

    public function getExam(Request $request)
    {
        try {
            $exam = Exam::with(["groups", "partials", "examgroups", "files"])->where("id", $request->id)->first();
            $datas = [];
            if ($exam != null && $exam->examgroups->count() > 0) {
                foreach ($exam->examgroups as $key => $eg) {
                    if ($eg->examgroupuser->count() > 0) {
                        foreach ($eg->examgroupuser as $key => $egu) {
                            $d = [
                                "name" => $egu->fullname,
                                "id" => $egu->id,
                                "school" => $egu->school->code,
                                "class" => $egu->class->code,
                                "branch" => $egu->branch->code,
                                "g_name" => $eg->groups->name,
                                "g_id" => $eg->groups->id,
                                "exam_group_id" => $eg->id
                            ];
                            array_push($datas, $d);
                        }
                    }
                }
            }
            unset($exam->examgroups);
            $exam["groupusers"] = $datas;
            return response()->json($exam, 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 200);
        }

    }

    public function shuffleData($data)
    {
        $collection = collect($data);
        $shuffled = $collection->shuffle();
        return $shuffled->all();
    }

    public function autoAssignGrup($groups, $students)
    {
        $tam = floor(count($students) / count($groups));
        $kalan = fmod(count($students), count($groups));
        $datas = [];
        $index = 0;
        foreach ($groups as $key => $group) {
            // if(count($datas) < count($students)){
            if ($index % $tam == 1) {
                $d = [
                    "student" => $students[$index - 1],
                    "group" => $group
                ];
                array_push($datas, $d);
            }
            for ($i = $index; $i < count($students); $i++) {
                if ($i != 0 && (fmod($i, $tam) == 0)) {
                    $index = $i + 1;
                    break 1;
                } else {
                    $d = [
                        "student" => $students[$i],
                        "group" => $group
                    ];
                    array_push($datas, $d);
                }
            }


        }

        for ($i = 0; $i < $kalan; $i++) {
            $r_students = array_reverse($students);
            $d = [
                "student" => $r_students[$i],
                "group" => $groups[$i]
            ];
            array_push($datas, $d);

        }
        return $datas;
    }

    public function getExamStudents(Request $request)
    {
        try {
            if ($request->branch_id === 0) {
                $students = User::with(['school', 'class', 'branch'])->where(
                    [
                        ['status', '=', 0],
                        ['type', '=', 0],
                        ['school_id', '=', $request->school_id],
                        ['class_id', '=', $request->class_id]
                    ]
                )->get();

            } else {
                $students = User::with(['school', 'class', 'branch'])->where(
                    [
                        ['status', '=', 0],
                        ['type', '=', 0],
                        ['school_id', '=', $request->school_id],
                        ['class_id', '=', $request->class_id],
                        ['branch_id', '=', $request->branch_id]
                    ]
                )->get();
            }

            $egroups = ExamGroup::with("groups")->where("exam_id", $request->exam_id)->get();
            $groups = $this->shuffleData($egroups);
            $students = $this->shuffleData($students);
            if (count($groups) > 0 && count($students) > 0) {
                $results = $this->autoAssignGrup($groups, $students);
                $datas = [];
                foreach ($results as $key => $result) {
                    $d = [
                        "name" => $result["student"]->fullname,
                        "id" => $result["student"]->id,
                        "school" => $result["student"]->school->code,
                        "class" => $result["student"]->class->code,
                        "branch" => $result["student"]->branch->code,
                        "g_name" => $result["group"]->groups->name,
                        "g_id" => $result["group"]->groups->id,
                        "exam_group_id" => $result["group"]->id
                    ];
                    array_push($datas, $d);
                }

                return response()->json($datas, 200);

            } else {
                return response()->json(["message" => "Bu sınava girecek sistemde öğrenci bulunmamaktadır."], 203);
            }


        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }

    public function store(Request $request)
    {
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
            if ($examcheck->count() > 0) {
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

    public function index(Request $request)
    {

        try {
            return User::with(['examgroupuser'])->where("id", $request->userid)->whereHas("examgroupuser", function ($q) use ($request) {
                $q->where("exam_id", $request->examid);
            })->get();
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }


        /*
                return Exam::with(["examgroup", 'examtype', 'school', 'lesson', 'class', 'branch', 'exampartial'])
                    ->whereHas("examgroup.examgroupuser", function ($q) {
                        $q->where("examgroup_user.id", 5);
                    })
                    ->where("id", $id)->get();*/
    }

    //boş olan kayıtlar 6 giriyorum options tablosunda

    public function createstudentexam(Request $request)
    {
        try {
            $valid = Validator::make($request->all(), [
                'examList' => 'required',
            ]);
            if ($valid->fails()) {
                return response()->json(["message" => 'Eksik data gönderimi.'], 400);
            }
            $allsaved = false;
            foreach ($request->examList as $item) {
                $studentexam = new ExamContent();
                $studentexam->user_id = $item['userid'];
                $studentexam->question_id = $item['questionid'];
                $studentexam->option_id = $item['optionid'];
                $studentexam->exam_group_id = $item['examgroupid'];
                if ($studentexam->save()) {
                    $allsaved = true;
                } else {
                    $allsaved = false;
                }
            }
            if ($allsaved == true) {
                return response()->json("Sınav Tamamlandı", 200);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);

        }
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
            $day = $today->format("d-m-Y");
            return response()->json(['time' => $hour,'date'=>$day], 200);
        }

    }

    public function getStudentExam(Request $request)
    {
        try {

            /*      $users = User::with(["examgroupuser"])
                      ->doesntHave("examcontents")
                      ->where("id",422)
                      ->has("examgroupuser")
                      ->whereHas('examgroupuser.exam', function ($query) use($request) {
                          $query->where("examDate","2020-03-27");
                      })
                      ->get();
                  return $users;*/
                  date_default_timezone_set('Europe/Istanbul');
            $data = DB::table('users')
                ->join('examgroup_user', 'examgroup_user.user_id', '=', 'users.id')
                ->join('exam_groups', 'exam_groups.id', '=', 'examgroup_user.exam_group_id')
                ->join('exams', 'exams.id', '=', 'exam_groups.exam_id')
                ->join('exam_types', 'exam_types.id', '=', 'exams.exam_type_id')
                ->select("users.*", "examgroup_user.*", "exam_groups.*", "exams.*", "exam_types.*")
                ->where([
                    ['users.id', '=', $request->userid],
                    ['exams.examDate', '=', date("Y-m-d")]
                ])
                ->get();

            return $data;

            /*   $test = User::with(['examgroupuser'])->where("id", $request->userid)->get();
               return $test;*/
            /* $exams = Exam::with(['examtype'])->where([
                 ["school_id", "=", $request->schoolid],
                 ['class_id', '=', $request->classid],
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
             return response()->json(["exam" => $exams, "unitexam" => $unitexams], 200);*/
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }


    public function storeUpdate(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'beginHour' => 'required',
            'endHour' => 'required',
            'examDate' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json(["message" => 'Eksik data gönderimi.'], 200);
        }
        try {
            $exam = Exam::findOrFail($request->id);
            $exam->name = $request->name;
            $exam->beginHour = $request->beginHour;
            $exam->endHour = $request->endHour;
            $exam->examDate = $request->examDate;
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
}



