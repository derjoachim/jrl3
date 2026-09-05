<?php

use Illuminate\Database\Seeder;

class FitnessServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fitness_services')->delete();

        $fitness_services = array(
          ['id'=> 1, 'name' => 'Strava', 'slug' => 'strava', 'api_key' => '37e3a9749671413a23cc2ca06e6637fc51203ace', 'description' => 'Strava']
        );

        DB::table('fitness_services')->insert($fitness_services);        
    }
}
