<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/file", "FileController@index");

Route::post("user/import", "FileController@userImport");
Route::post("user/upload", "UserController@upload");
Route::post("test", "TestController@test");
Route::post("testt", "TestController@testt");
Route::get("test", "TestController@index");
Route::get("scblists", "SchoolClassBranchPivotController@index");

//exam
Route::post("examcreate", "ExamController@store");
Route::post("examupdate", "ExamController@storeUpdate");
Route::post("exams", "ExamController@getExams");
Route::post("getexam", "ExamController@getExam");
Route::delete("/delexam/{id}", "ExamController@destroy");
Route::post("exampartialcreate", "ExamPartialController@store");


Route::post("examgroupfilelists", "ExamGroupController@getGroupFileLists");
Route::post("exampartials", "ExamPartialController@getPartialLists");
Route::delete("delexampartial/{id}", "ExamPartialController@destroy");
Route::post("saveExamFile", "FileController@saveExamFile");
Route::post("filedownload", "FileController@fileDownload");
Route::post("examgroupfilecreate", "ExamGroupController@store");
Route::delete("delexamgroupfile/{id}", "ExamGroupController@destroy");
Route::post("examstudents", "ExamController@getExamStudents");

Route::post("createexamusergroup", "ExamgroupUserController@store");
Route::post("delexamusergroups", "ExamgroupUserController@remove");


Route::post("createdatfile", "ExamFileController@createDatFile");
Route::post("getexamdatfiles", "ExamFileController@getExamDatFiles");
Route::post("downexamdatfiles", "ExamFileController@downExamDatFiles");
Route::post("removedatfile", "ExamFileController@removeDatFile");


//exam


/*Yasin*/
Route::post("/getStudentUnitExam", "ExamController@getStudentUnitExam");
Route::post("/getStudentExam", "ExamController@getStudentExam");
Route::post("/exam", "ExamController@index");
Route::post("/checkExamDate", "ExamController@dateTimeControl");
Route::post("/createStudentExam", "ExamController@createstudentexam");

Route::post("/lesson", "LessonController@store");
Route::delete("/lesson/{id}", "LessonController@destroy");
Route::put("/lesson/{id}", "LessonController@update");
Route::get("/lesson", "LessonController@index");


Route::post("/group", "GroupController@store");
Route::delete("/group/{id}", "GroupController@destroy");
Route::put("/group/{id}", "GroupController@update");
Route::get("/group", "GroupController@index");

Route::post("/branch", "BranchController@store");
Route::delete("/branch/{id}", "BranchController@destroy");
Route::put("/branch/{id}", "BranchController@update");
Route::get("/branch", "BranchController@index");

Route::post("/clases", "ClassController@store");
Route::delete("/clases/{id}", "ClassController@destroy");
Route::put("/clases/{id}", "ClassController@update");
Route::get("/clases", "ClassController@index");

Route::post("/etype", "ExamTypeController@store");
Route::delete("/etype/{id}", "ExamTypeController@destroy");
Route::put("/etype/{id}", "ExamTypeController@update");
Route::get("/etype", "ExamTypeController@index");


Route::post("/options", "OptionController@store");
Route::delete("/options/{id}", "OptionController@destroy");
Route::put("/options/{id}", "OptionController@update");
Route::get("/options", "OptionController@index");
//->middleware(\App\Http\Middleware\TokenControl::class);

Route::post("/chapter", "ChapterController@store");
Route::delete("/chapter/{id}", "ChapterController@destroy");
Route::put("/chapter/{id}", "ChapterController@update");
Route::get("/chapter", "ChapterController@index");

Route::post("/schools", "SchoolController@store");
Route::delete("/schools/{id}", "SchoolController@destroy");
Route::put("/schools/{id}", "SchoolController@update");
Route::get("/schools", "SchoolController@index");
Route::post("/getSCB", "SchoolController@getSCB");
Route::post("/addSCB", "SchoolController@addSCB");
Route::post("/deleteSCB", "SchoolController@delSCB");

Route::post("/changepass", "UserController@changePassword");
Route::get("/persons", "UserController@getpersons");
Route::put("/persons/{id}", "UserController@updatepersons");
Route::delete("/persons/{id}", "UserController@deleteperson");
Route::post("/addperson", "UserController@addpersons");
Route::post("/student", "UserController@store");
Route::post("/getstudent", "UserController@index");
Route::delete("/student/{id}", "UserController@destroy");
Route::put("/student/{id}", "UserController@update");

Route::post("/login", "UserController@login");
/* Yasin */
