<?php

use Illuminate\Database\Seeder;

class RoutesTableSeeder extends Seeder {
    public function run() {
        DB::table('routes')->delete();

        $routes = array(
          ['id'=> 1, 'name' => 'Engelermeer', 'slug' => 'engelermeer', 'description' => 'Kleine ronde Engelermeer', 'distance' => 4.5, 'rating' => 3, 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['id' => 2, 'name' => 'Engelermeer - Vlijmen', 'slug' => 'engelermeer-vlijmen', 'description' => 'Kleine ronde Vlijmen', 'distance' => 7.6, 'rating' => 3, 'created_at' => new DateTime, 'updated_at' => new DateTime],
          ['id' => 3, 'name' => 'Vlijmen - Moerputten', 'slug' =>'vlijmen-moerputten', 'description' => 'Middelgrote ronde door de Moerputten', 'distance' => 9.8, 'rating' => 4, 'created_at' => new DateTime, 'updated_at' => new DateTime]  
        );

        DB::table('routes')->insert($routes);        
    }
}
