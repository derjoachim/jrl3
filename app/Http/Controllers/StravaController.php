<?php namespace Jrl3\Http\Controllers;
use Auth;
use Config;
use Carbon\Carbon;
use DB;
use Input;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Jrl3\Repositories\StravaServiceRepository;
use Illuminate\Http\Request;
//use Jrl3\FitnessService;
use Jrl3\Route;
use Jrl3\Workout;

class StravaController extends Controller {
    
    private $fs;
    
    public function __construct(StravaServiceRepository $stravaRepository) 
    {
        $this->fs = $stravaRepository;
    }
    
    public function latest()
    {
        $latest_strava_workouts = $this->fs->latest();
        $body = json_decode($latest_strava_workouts->body);
        $workouts = array();
        $tz = Config::get('app.timezone');

        foreach($body as $w) {
            $arrW = array();
            $arrW['id'] = $w->id;
            $ts = Carbon::parse($w->start_date,'UTC');
            $ts->setTimezone($tz);
            $arrW['date'] = $ts->format('d-m-Y');
            $arrW['name'] = $w->name;
            $arrW['distance'] = round($w->distance / 1000, 2);
            $arrW['time'] = $this->fs->getTime($w->elapsed_time);
            $arrW['workout_id'] = $this->fs->getWorkoutid($w->id);
            $workouts[] = $arrW;
        }
        return view('strava.index',compact('workouts'));
    }
    
    public function import()
    {
        $id = Input::get('id');
        $activity = $this->fs->import($id);

        $body = json_decode($activity->body);
        $arrPolylinePoints = $this->fs->decodePolylineToArray($body->map->polyline);
        $first = $arrPolylinePoints[0];
        $last = array_pop($arrPolylinePoints);
        
        $ts = Carbon::parse($body->start_date,'UTC');
        $ts->setTimezone(Config::get('app.timezone'));
        
        $arrFld = array(
            'name' => $body->name,
            'date' => $ts->format('Y-m-d'),
            'slug' => $ts->format('Y-m-d').'-'.'strava-import', 
            'user_id' => Auth::user()->id,
            'distance' => round(($body->distance / 1000) ,2),
            'start_time' => $ts->format('H:i:s'),
            'time_in_seconds' => $body->moving_time,
            'lat_start' => $first[0], 
            'lon_start' => $first[1],
            'lat_finish' => $last[0],
            'lon_finish' => $last[1],
            'description' => $body->description,
            'created_at' => Carbon::now(),
        );
        
        $workout_id = DB::table('workouts')->insertGetId($arrFld);

        // Parse polyline into coordinates, create waypoint records.
        $arrWps = array();
        foreach ( $arrPolylinePoints as $wp ) {
            $arrWps[] = array(
                'workout_id' => $workout_id,
                'lon' => $wp[1],
                'lat' => $wp[0]
            );
        }
        DB::table('waypoints')->insert($arrWps);
     
        // mark this workout as 'imported' from Strava.
        $arSrv = array(
            'workout_id' => $workout_id,
            'fitness_service_id' => $this->fs->service_id,
            'fitness_service_remote_identifier' => Input::get('id'),
            'timestamp' => Carbon::now()
        );
        DB::table('workouts_fitness_services')->insert($arSrv);
        
        // Redirect to the edit screen
        $workout = Workout::find($workout_id);
        $routes = array('' => '--- Geen route ---') + Route::lists('name','id')->all();
        $t = $workout->getTime();
        $date = $workout->date->format('Y-m-d');
        $mood = 3;
        $health = 3;
        return view('workouts.edit', compact('workout','routes','mood','health','t','date'));
    }
}