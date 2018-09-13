<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tasks', function(Blueprint $table){
          $table->integer('type')->unsigned();
          $table->string('platform')->nullable();
          $table->string('version')->nullable();
          $table->integer('task_id')->unsigned()->nullable();
          $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('tasks', function(Blueprint $table){
          $table->dropColumn('type');
          $table->dropColumn('platform');
          $table->dropColumn('version');
          $table->dropForeign(['task_id']);
          $table->dropColumn('task_id');
        });
    }
}
