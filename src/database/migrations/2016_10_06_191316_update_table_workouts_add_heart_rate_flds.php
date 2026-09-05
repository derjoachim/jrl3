<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableWorkoutsAddHeartRateFlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function($table){
            $table->mediumInteger('avg_hr')->nullable()->after('health');
            $table->mediumInteger('max_hr')->nullable()->after('avg_hr');
            
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
            if ('sqlite' !== env('DB_CONNECTION')) {
                $table->dropColumn('avg_hr');
                $table->dropColumn('max_hr');
            }
        });
    }
}
