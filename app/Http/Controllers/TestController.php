<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\School;
use App\Models\ExamContent;
use App\Models\ExamPartial;
use App\Models\ExamGroup;
use App\Models\Branch;
use App\Models\File;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamgroupUser;
class TestController extends Controller
{

    public function sortedQuestions($contents){
        $collection = collect($contents);
        $sorted = $collection->sortBy("question.qNo");
        return $sorted->values()->all();
    }

    public function testt(Request $request){
        $file_name = "public/examdats/dat$request->id.dat";
        $eps = ExamPartial::with("chapter")->where("exam_id", $request->id)->get();
        $datas = [];
       $users = User::with(["examcontents"])
       ->has("examcontents")
       ->with(['examgroups' => function ($query) use($request) {
            $query->where('exam_id',$request["id"]);
        }])->get();
        foreach ($users as $key => $user) {
            $answer = "";
            $sortedQcontents = $this->sortedQuestions($user->examcontents);
            foreach ($sortedQcontents as $key => $uec) {
               if($uec->exam_group->exam_id === $request["id"]){
                $opt = $uec->option->id === 6 ? " " : $uec->option->name;
                $answer = $answer . $opt;
               }
            }
            $d = [];
            foreach ($eps as $key => $ep) {
                $d[$ep->chapter->name]=substr($answer, $ep->startQ-1, ($ep->endQ - $ep->startQ)+1);
            }
            if($answer != ""){
                $d = [
                    "user"=>$user->tc,
                    "group"=>$user->examgroups[0]->groups->name,
                    "answer"=>$answer,
                    "chapters"=>$d,
                ];
                array_push($datas, $d);
            }
        }
        $bosluk = "-";
        $line = "";
        $results = [];
        foreach ($datas as $key => $data) {
             $chapterline = "";
            foreach ($eps as $key1 => $ep) {
                $chapterline = $chapterline . $data["chapters"][$ep->chapter->name] . $bosluk;
            }
            if ($key === 0) {
             
                $line = $data['user'] . $bosluk . $data["group"] . $bosluk . $chapterline;
                array_push($results, $line);
                //  Storage::put("$file_name", $line);
            } else {
                $line = $data['user'] . $bosluk . $data["group"] . $bosluk . $chapterline;
                array_push($results, $line);
                //  Storage::append("$file_name", $line);
            }

        }
        foreach ($results as $k => $result) {
            if ($k === 0) {
               Storage::put("$file_name", $result);
            } else {
                Storage::append("$file_name", $result);
            }
        }
        return $results;
        return $line;

        return $datas;
        try {
            $spath = Storage::url($file_name);
            $file = new File();
            $file->path = env("HOST_URL") . $spath;
            if ($file->save()) {
                 $ef = new ExamFile();
                 $ef->exam_id = $request->id;
                 $ef->file_id = $file->id;
                 if($ef->save()){
                    return response()->json($file, 201);
                 } else {
                    return response()->json(['message'=>"Dosya sınav ilişkisi kaydedilemedi."], 200);
                 }
                
            } else {
                return response()->json(['message'=>"Dosya kaydedilemedi."], 200);
           }
        } catch (\Throwable $th) {
            return response()->json(["message"=>$th->getMessage()], 200);
        }
    }
    public function contentAtamaTest(){
                // $eg = ExamGroup::with(["contents"])->where("exam_id", 65)->get()->groupBy("contents.user.id");
        // return $eg;



        // $questions = Question::where("exam_group_id", 51)->get();
        // $options = [1,2,3,4,5,6];
        // foreach ($questions as $key => $q) {
        //     $collection = collect($options);
        //     $shuffled = $collection->shuffle();
        //     $options = $shuffled->all();
        //     $ec = new ExamContent();
        //     $ec->question_id = $q->id;
        //     $ec->user_id = 513;
        //     $ec->option_id = $options[0];
        //     $ec->exam_group_id = 51;
        //     $ec->save();
        // }
        // return $questions;
    }
    public function index()
    {

        $groups = ["A", "B", "C", "D"];
        $students = ["Adem", "ahmet", "ali", "yasin", "Bülent", "Mustafa", "Özge", "deniz","Elif"];
        $tam = floor(count($students) / count($groups));
        $kalan = fmod(count($students), count($groups));
        $datas = [];
        $index = 0;
        foreach ($groups as $key => $group) {
            if(count($datas) < count($students)){
                if($index%count($groups) == 1){
                    $d = [
                        "student"=>$students[$index-1],
                        "group"=>$group
                      ];
                      array_push($datas, $d);
                }
                for ($i=$index; $i < count($students); $i++) {
                    if($i != 0 &&  (fmod($i, count($groups)) == 0)){
                        $index = $i+1;
                       break 1;
                    } else {
                        $d = [
                          "student"=>$students[$i],
                          "group"=>$group,
                          "kalan"=>$kalan,
                        ];
                        array_push($datas, $d);
                    }
                }

            }

        }

        // for($i = 0; $i < $kalan; $i++){
        //     $students_r = array_reverse($students);
        //     $d = [
        //         "student"=>$students_r[$i],
        //         "group"=>$groups[$i],
        //       ];
        //       array_push($datas, $d);
        // }


        return $datas;
        return floor (99/4);
        return $r = fmod(99, 4);
        // try {
        //     $file = File::findOrFail(26);
        //     $dilimler = explode("storage/", $file->path);
        //     $dpath = 'app/public/'.$dilimler[1];
        //     return response()->download(storage_path($dpath));
        // } catch (\Throwable $th) {
        //     return response()->json($th->getMessage());
        // }

    $headers = array(
        'Content-Type: application/pdf',
      );
              $file = File::findOrFail(26);
            $dilimler = explode("storage/", $file->path);
            $dpath = 'app/public/'.$dilimler[1];

            return response()->download(storage_path($dpath), "deneme", $headers);

        $path = "app/public/exams/KewvUsQvqvA5uJgXJy7DaUiUZ4sh9tEgDQfc2HMU.pdf";
        return response()->download(storage_path($dpath));
        $file = Storage::disk('public')->get(storage_path("app/public/exams/KewvUsQvqvA5uJgXJy7DaUiUZ4sh9tEgDQfc2HMU.pdf"));
        return response()->download($file);
        $file = File::find(8);
        $dilimler = explode("storage/", $file->path);
        $dpath = 'app/public/'.$dilimler[1];
        try {
            return Storage::get("http://e-exam//storage/exams/KewvUsQvqvA5uJgXJy7DaUiUZ4sh9tEgDQfc2HMU.pdf");
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
        $no = ["0216", "0215", "0214"];
        $tc = "11111111111";
        $sinif = "042";
        $group = "A";
        $bosluk = "   ";

        $info = "0424B000216A           ";
        $infos = [
            "0424B000216A           ",
            "0424B000214A           ",
            "0424B000217B           "
        ];
        $fullnames = ["adem özgen          ", "yasin dalkilic      ", "ali akcan           "];
        $chapter1 = "CBAAAABBCCADBDA               ";
        $chapter2 = "DCCADDCACDDCAAD               ";
        $chapter3 = "DCCADDCCCDDCAAD               ";
        $chapter4 = "CBAAABBDCCADBDA               ";

        foreach ($fullnames as $key => $name) {
            $line = $name . $bosluk . $no[$key] . $bosluk . $tc . $bosluk . $sinif . $bosluk . $group . $bosluk . $chapter1 . $chapter2 . $chapter3 . $chapter4;
            //  $line = $key.$line;
            if ($key === 0) {
                Storage::put('public/file.dat', $line);
            } else {
                Storage::append('public/file.dat', $line);
            }

        }

    }
    public function test(Request $request){

        $path = "http://e-exam/storage/exams/KewvUsQvqvA5uJgXJy7DaUiUZ4sh9tEgDQfc2HMU.pdf";
        $dilimler = explode("storage/", $path);
        $dpath = 'app/public/'.$dilimler[1];
        $url = Storage::url($dpath);
        try {
            return Storage::download(storage_path("app/public/exams/KewvUsQvqvA5uJgXJy7DaUiUZ4sh9tEgDQfc2HMU.pdf"));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }

        return $request;
        $schools = School::with(['classes'])->has("classes")->get();
        $scb = [];
        foreach ($schools as $key => $school) {
            $collection = collect($school->classes);
            $unique = $collection->unique('id');
            unset($school["classes"]);
            $school["classes"] = $unique->values()->all();
            foreach ($unique->values()->all() as $key => $class) {
                $collectionclass = collect($class->branches);
                $uniqueclass = $collectionclass->unique('id');
                unset($class["branches"]);
                $class["branches"] = $uniqueclass->values()->all();
            }
            array_push($scb, $school);
        }
        return $scb;

    }
}
