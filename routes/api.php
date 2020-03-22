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

Route::post("user/import", "UserController@import");
Route::post("user/upload", "UserController@upload");
Route::post("test", "TestController@test");


/*Yasin*/
Route::post("/getStudentUnitExam", "ExamController@getStudentUnitExam");
Route::post("/getStudentExam", "ExamController@getStudentExam");
Route::get("/exam/{id}", "ExamController@index");
Route::post("/checkExamDate", "ExamController@dateTimeControl");

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


Route::post("/student", "UserController@store");
Route::get("/student", "UserController@index");
Route::delete("/student/{id}", "UserController@destroy");
Route::put("/student/{id}", "UserController@update");

Route::post("/login", "UserController@login");
/* Yasin */
