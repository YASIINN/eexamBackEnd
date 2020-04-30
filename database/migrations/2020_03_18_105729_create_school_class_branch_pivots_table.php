<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolClassBranchPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_class_branch_pivots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("school_id");
            $table->unsignedBigInteger("class_id");
            $table->unsignedBigInteger("branch_id");
            $table->foreign('school_id')->references('id')->on('schools')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('class_id')->references('id')->on('classes')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('school_class_branch_pivots');
    }
}
