<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesAndWorkoutsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('routes', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->text('description')->default('');
            $table->string('lon_start')->nullable();
            $table->string('lat_start')->nullable();
            $table->string('lon_finish')->nullable();
            $table->string('lat_finish')->nullable();
            if('sqlite' == env('DB_CONNECTION')) {
                $table->smallInteger('rating')->default(3);
            } else {
                $table->tinyInteger('rating')->default(3);
            }
            $table->decimal('distance',4,2);
            $table->timestamps();
		});
                
        Schema::create('workouts',function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('route_id')->unsigned()->nullable();
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->date('date');
            $table->time('start_time')->nullable();
            if('sqlite' == env('DB_CONNECTION')) {
                $table->smallInteger('time_in_seconds')->default(0);
            } else {
                $table->tinyInteger('time_in_seconds')->default(0);
            }
            $table->boolean('finished')->default(1);
            $table->text('description')->default('');
            $table->string('lon_start')->nullable();
            $table->string('lat_start')->nullable();
            $table->string('lon_finish')->nullable();
            $table->string('lat_finish')->nullable();
            $table->decimal('distance',4,2)->default(0);
            if('sqlite' == env('DB_CONNECTION')) {
                $table->smallInteger('pressure')->unsigned()->nullable();
                $table->smallInteger('temperature')->unsigned()->nullable();
                $table->smallInteger('humidity')->unsigned()->nullable();
                $table->smallInteger('wind_speed')->unsigned()->nullable();
                $table->smallInteger('mood')->default(3);
                $table->smallInteger('health')->default(3);
            } else {
                $table->tinyInteger('pressure')->unsigned()->nullable();
                $table->tinyInteger('temperature')->unsigned()->nullable();
                $table->tinyInteger('humidity')->unsigned()->nullable();
                $table->tinyInteger('wind_speed')->unsigned()->nullable();
                $table->tinyInteger('mood')->default(3);
                $table->tinyInteger('health')->default(3);
            }
            $table->string('wind_direction',4)->default('');
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
        Schema::dropIfExists('workouts');
		Schema::dropIfExists('routes');
	}

}
