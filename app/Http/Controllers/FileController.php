<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Validator;

class FileController extends Controller
{
    public function pdfUpload(Request $request){

    }
    public function excellUpload(Request $request){

    }
    public  function  index(){
        return File::all();
    }
}
