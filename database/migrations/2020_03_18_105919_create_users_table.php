<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('fullname');
            $table->string('tc');
            $table->string('schoolNo');
            $table->tinyInteger('status');
            $table->tinyInteger('type');
            $table->string('email')->unique();
            $table->unsignedBigInteger("school_id");
            $table->unsignedBigInteger("class_id");
            $table->unsignedBigInteger("branch_id");
            $table->foreign('school_id')->references('id')->on('schools')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete("cascade")->onUpdate("cascade");
            $table->foreign('class_id')->references('id')->on('classes')->onDelete("cascade")->onUpdate("cascade");

            // $table->timestamp('email_verified_at')->nullable();
           $table->string('password');
            // $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
