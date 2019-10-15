<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFitnessserviceAddColumnsRefreshtoken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fitness_services', function(Blueprint $table){
            $table->string('refresh_token');
            $table->string('access_token');
            $table->integer('expires_at')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fitness_services', function(Blueprint $table){
            $table->dropColumn(['access_token','refresh_token','expires_at']);
        });
    }
}
