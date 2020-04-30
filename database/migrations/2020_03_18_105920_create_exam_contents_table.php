<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("question_id");
            $table->unsignedBigInteger("option_id");
            $table->unsignedBigInteger("exam_group_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('question_id')->references('id')->on('questions')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('option_id')->references('id')->on('options')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('exam_group_id')->references('id')->on('exam_groups')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('exam_contents');
    }
}
