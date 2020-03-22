<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_partials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("startQ");
            $table->string("endQ");
            $table->unsignedBigInteger("exam_id");
            $table->unsignedBigInteger("chapter_id");
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('exam_partials');
    }
}
