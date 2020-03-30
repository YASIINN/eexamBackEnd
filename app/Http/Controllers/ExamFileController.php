<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\School;
use App\Models\ExamContent;
use App\Models\ExamPartial;
use App\Models\ExamGroup;
use App\Models\Branch;
use App\Models\File;
use App\Models\User;
use App\Models\ExamFile;
use App\Models\Exam;

class ExamFileController extends Controller
{
    public function sortedQuestions($contents){
        $collection = collect($contents);
        $sorted = $collection->sortBy("question.qNo");
        return $sorted->values()->all();
    }
    public function removeDatFile(Request $request){
        try {
            
            if (File::destroy($request->id)) {
                return response()->json('Success', 200);
            } else {
                return response()->json(["message"=>"Silme işlemi sırasında hata meydana geldi."], 500);
            }
        } catch (\Exception $e) {
            return response()->json(["message"=>$e->getMessage()], 500);
        }

    }
    public function createDatFile(Request $request){
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
    public function getExamDatFiles(Request $request){
         $e = Exam::find($request->id);
         return $e->files;
        //  $dpath = "";
        //  foreach ($e->files as $key => $file) {
        //      return $file->path;
        //     $dilimler = explode("storage/", $file->path);
        //     $dpath = 'app/public/'.$dilimler[1];
        //  }
        // //  $file = File::findOrFail(26);
        // //  $dilimler = explode("storage/", $file->path);
        // //  $dpath = 'app/public/'.$dilimler[1];


        // return response()->download(storage_path($dpath), "deneme");
        //  return $e->files;
    }
    public function downExamDatFiles(Request $request){
    try {
        $dilimler = explode("storage/", $request->path);
        $dpath = 'app/public/'.$dilimler[1];
        $headers = ['Content-Type: text/dat'];
         return response()->download(storage_path($dpath), "deneme", $headers);
    } catch (\Throwable $th) {
        return response()->json($th->getMessage());
    }
    }
}
