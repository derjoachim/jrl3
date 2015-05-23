<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
//Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('forecast','ForecastController@fetch');
Route::get('upload','FilesController@upload');
Route::post('parse','FilesController@parse');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::model('routes','Route');
Route::model('workouts','Workout');

Route::resource('routes', 'RoutesController');
Route::resource('workouts', 'WorkoutsController');

Route::bind('routes', function($value, $route){
    return Jrl3\Route::whereSlug($value)->first();
});

Route::bind('workouts', function($value, $workout){
    return Jrl3\Workout::whereSlug($value)->first();
});