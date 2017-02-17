<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tasks')) 
		{
			Schema::create('tasks', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('projectId')->unsigned()->index();				
				$table->string('name');				
				$table->integer('taskPriority');
				$table->boolean('isComplete')->default(0);
				$table->timestamps();
				$table->foreign('projectId')->references('id')->on('projects')->onDelete('cascade');
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
