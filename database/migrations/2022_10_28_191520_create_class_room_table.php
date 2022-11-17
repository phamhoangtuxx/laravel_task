<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_room', function (Blueprint $table) {
            $table->integer('classroomID', 11)->unsigned();
            $table->string('name', 255);
            $table->string('icon', 128)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->integer('state')->comment('Trạng thái tài khoản, 1 : Kích hoạt,0 Block')->default(0);
            $table->string('createdBy', 40);
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
        Schema::dropIfExists('class_room');
    }
}
