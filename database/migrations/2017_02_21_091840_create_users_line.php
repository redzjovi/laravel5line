<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLine extends Migration
{
    public function up()
    {
        Schema::create('users_line', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->references('id')->on('users')->unique();
            $table->string('line_id')->unique();
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_line');
    }
}