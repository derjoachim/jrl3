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
                    $table->string('name')->default('');
                    $table->string('slug')->default('');
                    $table->text('description')->default('');
                    $table->string('lon_start')->nullable();
                    $table->string('lat_start')->nullable();
                    $table->string('lon_finish')->nullable();
                    $table->string('lat_finish')->nullable();
                    $table->tinyInteger('rating')->default(3);
                    $table->decimal('distance',4,2);
                    $table->timestamps();
		});
                
                Schema::create('workouts',function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('route_id')->unsigned()->default(0);
                    $table->string('name')->default('');
                    $table->string('slug')->default('');
                    $table->date('date');
                    $table->time('start_time')->nullable();
                    $table->tinyInteger('time_in_seconds')->default(0);
                    $table->boolean('finished')->default(1);
                    $table->text('description')->default('');
                    $table->string('lon_start')->nullable();
                    $table->string('lat_start')->nullable();
                    $table->string('lon_finish')->nullable();
                    $table->string('lat_finish')->nullable();
                    $table->decimal('distance',4,2)->default(0);
                    $table->tinyInteger('pressure')->unsigned()->nullable();
                    $table->tinyInteger('temperature')->unsigned()->nullable();
                    $table->tinyInteger('wind_speed')->unsigned()->nullable();
                    $table->char('wind_direction',2)->default('');
                    $table->tinyInteger('mood')->default(3);
                    $table->tinyInteger('health')->default(3);
                    $table->timestamps();
                    $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
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
