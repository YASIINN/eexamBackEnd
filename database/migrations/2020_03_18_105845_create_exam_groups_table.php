<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("exam_id");
            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("file_id");
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('group_id')->references('id')->on('groups')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('exam_groups');
    }
}
