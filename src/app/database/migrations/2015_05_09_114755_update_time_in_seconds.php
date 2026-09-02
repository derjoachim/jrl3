<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimeInSeconds extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('workouts', function($table){
           $table->smallInteger('time_in_seconds')->default(0)->change(); 
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('workouts', function($table){
           $table->tinyInteger('time_in_seconds')->default(0)->change(); 
        });
	}

}
