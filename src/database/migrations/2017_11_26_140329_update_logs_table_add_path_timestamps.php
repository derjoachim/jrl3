<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLogsTableAddPathTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function($table){
            $table->string('path')->nullable();
//            $table->timestamps();
        });

        Schema::table('logs', function($table) {
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
        Schema::table('logs', function($table) {
            $table->dropColumn('path');
        });

        Schema::table('logs', function($table) {
            $table->dropTimestamps();
        });
    }
}
