<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToMb4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if('sqlite' !== env('DB_CONNECTION')) {
            DB::statement("ALTER TABLE workouts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE routes CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            DB::statement("ALTER TABLE logs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
