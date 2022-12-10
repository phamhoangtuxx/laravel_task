<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassroomMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_member', function (Blueprint $table) {

            $table->unsignedBigInteger('classroom_id');
            $table->foreign('classroom_Id')->references('id_classroom')->on('class_room')->onDelete('cascade');
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('users');
            $table->integer('State')->default(0);
            $table->timestamp('AcceptAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroomMember', function (Blueprint $table) {
            //
        });
    }
}
