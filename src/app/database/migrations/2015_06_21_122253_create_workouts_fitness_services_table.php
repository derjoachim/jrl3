<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutsFitnessServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
 		Schema::create('workouts_fitness_services', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('workout_id')->unsigned();
            $table->integer('fitness_service_id')->unsigned;
            $table->string('fitness_service_remote_identifier');
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
		Schema::drop('workouts_fitness_services');
	}
}
