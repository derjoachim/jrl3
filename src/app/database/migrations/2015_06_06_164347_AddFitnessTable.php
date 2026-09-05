<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFitnessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('fitness_services', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('slug')->default('');
            $table->string('api_key')->default('');
            $table->text('description')->default('');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('fitness_services');
	}

}
