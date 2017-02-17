<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('projects')) 
		{
			Schema::create('projects', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->dateTime('deadlineTime');
				/*$table->integer('projectPriority');
				$table->boolean('isComplete')->default(0);*/
				$table->timestamps();
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
        Schema::drop('projects');
    }
}
