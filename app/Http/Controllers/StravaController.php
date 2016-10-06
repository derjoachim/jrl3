<?php namespace App\Http\Controllers;
use Auth;
use Config;
use Carbon\Carbon;
use DB;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\StravaServiceRepository;
use Illuminate\Http\Request;
//use App\FitnessService;
use App\Route;
use App\Workout;

class StravaController extends Controller {
    
    private $fs;
    
    public function __construct(StravaServiceRepository $stravaRepository) 
    {
        $this->fs = $stravaRepository;
    }
    
    public function latest()
    {
        $latest_strava_workouts = $this->fs->latest();
        $body = json_decode($latest_strava_workouts);
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

        $body = json_decode($activity);
        $arrPolylinePoints = $this->fs->decodePolylineToArray($body->map->polyline);
        
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
            'description' => $body->description,
            'avg_hr' => $body->average_heartrate,
            'max_hr' => $body->max_heartrate,
            'created_at' => Carbon::now(),
        );
        if( count($arrPolylinePoints) > 0) {
            $first = $arrPolylinePoints[0];
            $last = array_pop($arrPolylinePoints);
            $arrFld['lat_start'] = $first[0];
            $arrFld['lon_start'] = $first[1];
            $arrFld['lat_finish'] = $last[0];
            $arrFld['lon_finish'] = $last[1];
        }
        
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
        if(count($arrWps) > 0) {
            DB::table('waypoints')->insert($arrWps);
        }
     
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