<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("file_id");
            $table->unsignedBigInteger("exam_id");
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('file_id')->references('id')->on('files')->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_file');
    }
}
