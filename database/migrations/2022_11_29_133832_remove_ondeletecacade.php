<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOndeletecacade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('HistoryEmail', function (Blueprint $table) {
            $table->dropForeign('historyemail_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('HistoryEmail', function (Blueprint $table) {
            $table->dropForeign('historyemail_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
