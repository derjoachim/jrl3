<?php
Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');

Route::get('forecast','ForecastController@fetch');
Route::get('upload','FilesController@upload');
Route::post('parse','WorkoutsController@parse');
Route::get('waypoints','WorkoutsController@waypoints');
Route::get('routes/byid','RoutesController@getById');

Route::get('strava/getlatest','StravaController@latest');
Route::get('strava/import', array('as' => 'strava-import', 'uses' => 'StravaController@import'));

Route::resource('routes', 'RoutesController');
Route::resource('workouts', 'WorkoutsController');

Route::resource('logs', 'LogsController');
Route::get('logs/{id}/download/', array('uses' => 'LogsController@download'));

Route::bind('routes', function($value, App\Models\Route $route){
    return App\Models\Route::where('slug', $value)->first();
});

Route::bind('workouts', function($value, App\Models\Workout $workout){
    return App\Models\Workout::where('slug', $value)->first();
});
