<?php namespace Jrl3\Http\Controllers;
use Config;
use Carbon\Carbon;
use Input;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Jrl3\Repositories\StravaServiceRepository;
use Illuminate\Http\Request;
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
        $body = json_decode($latest_strava_workouts->body);//->toJson();
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
            $arrW['time'] = $this->getTime($w->elapsed_time);
            $workouts[] = $arrW;
        }
        return view('strava.index',compact('workouts'));
    }
    
    public function import()
    {
        $id = Input::get('id');
        $activity = $this->fs->import($id);
        dd($activity);
    }
    
    private function getTime($secs)
    {
        $t = ($secs > 3600 ? 'H:' : '') . 'i:s';
        return gmdate($t, $secs);
    }
}
