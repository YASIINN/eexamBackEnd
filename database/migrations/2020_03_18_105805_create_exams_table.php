<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->integer("optCount");
            $table->integer("qCount");
            $table->string("beginHour");
            $table->string("endHour");
            $table->string("checkExam");
            $table->timestamp("beginDate")->nullable();
            $table->timestamp("endDate")->nullable();
            $table->date("examDate")->nullable();
            $table->unsignedBigInteger("exam_type_id");
            $table->unsignedBigInteger("lesson_id");
            $table->unsignedBigInteger("school_id");
            $table->unsignedBigInteger("class_id");
            $table->unsignedBigInteger("branch_id");
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('school_id')->references('id')->on('schools')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('class_id')->references('id')->on('classes')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('exams');
    }
}
