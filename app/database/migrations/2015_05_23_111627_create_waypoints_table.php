<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaypointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waypoints', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('workout_id')->unsigned();
            $table->string('lat');
            $table->string('lon');
            $table->dateTimeTz('timestamp');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('Cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropForeign('workout_id');
		Schema::drop('waypoints');
	}

}
