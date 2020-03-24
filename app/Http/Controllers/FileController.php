<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Validator;
use Storage;
use Illuminate\Http\Response;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function pdfUpload(Request $request){

    }
    public function excellUpload(Request $request){

    }
    public function userImport(Request $request){
       try {
           Excel::import(new UsersImport, $request->file("file"));
           return response()->json(["message"=>"Başarılı"]);
        } catch (\Throwable $th) {
            return response()->json(["message"=>$th->getMessage()]);
        }
    }
    public  function  index(){
        return File::all();
    }
    public function saveExamFile(Request $request){
        $valid = Validator::make($request->all(), [
            'file' => 'mimes:pdf|required|max:20000',
        ]);
        if ($valid->fails()) {
            return response()->json(['message' => $valid->errors()], 200);
        }
        try {
            $path = $request->file('file')->store(
                'public/exams'
            );
            $spath = Storage::url($path);
                    $file = new File();
                    $file->path = env("HOST_URL") . $spath;
                    if ($file->save()) {
                        return response()->json($file, 201);
                    } else {
                        return response()->json(['message'=>"Dosya yüklenemedi"], 200);
                    }
        } catch (\Throwable $th) {
            return response()->json(["message"=>"Dosya yüklenirken hata meydana geldi."], 200);
        }
    }
    public function fileDownload(Request $request){
        try {

    $headers = array(
        'Content-Type: application/pdf',
      );
            $file = File::findOrFail($request->id);
            $dilimler = explode("storage/", $file->path);
            $dpath = 'app/public/'.$dilimler[1];
            return response()->download(storage_path($dpath, "deneme", $headers));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
