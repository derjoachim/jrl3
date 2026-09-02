<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWeatherDataWorkouts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    if('sqlite' != env('DB_CONNECTION')) {
            Schema::table('workouts', function($table){
                $table->smallInteger('pressure')->nullable()->change();
                $table->smallInteger('humidity')->nullable()->after('pressure');
                $table->smallInteger('temperature')->nullable()->change();
                $table->smallInteger('wind_speed')->nullable()->change();
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
	    if('sqlite' != env('DB_CONNECTION')) {
            Schema::table('workouts', function($table){
                $table->tinyInteger('pressure')->unsigned()->nullable();
                $table->tinyInteger('temperature')->unsigned()->nullable();
                $table->tinyInteger('wind_speed')->unsigned()->nullable();
                $table->dropColumn('humidity');
            });
        
        }
  	}

}
