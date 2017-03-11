<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\Route;
use Auth;
use Carbon\Carbon;
use Config; 
use DB;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class WorkoutsController extends Controller {

    protected $rules = [
        'date' => ['required','date'],
        'name' => ['required','min:3'],
        'description' => ['required','min:10'],
        'avg_hr' => ['numeric', 'digits:3'],
        'max_hr' => ['numeric', 'digits:3'],
    ];

    /**
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return view
     */
    public function index(Request $request)
    {
        $workouts = Workout::latest('date')->whereUserId(Auth::user()->id)->paginate(10);
        $routes = Route::getAllInArray();
        
        // @TODO: This is a quick 'n dirty solution. There probably a better
        // solution
        foreach( $workouts as $workout) {
            $workout->time = $workout->getTime('time_in_seconds');
            $workout->route = trans('app.none');
            $route_id = $workout->route_id;
            if($route_id > 0 && array_key_exists($route_id, $routes)) {
                $workout->route = $routes[$route_id];
            }
        }
        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $data = array();
        $data['routes'] = Route::getAllInArray();
        $data['date'] = date("Y-m-d");
        return view('workouts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Models\Workout $workout
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $input = $request->all();
        $input['user_id'] = $request->user()->id; //hackish, pls refactor
        $workout = new Workout($input);
        $workout->save();

        return Redirect::route('workouts.index')->with('message', trans('jrl.workout_saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Workout $workout
     * @return Response
     */
    public function show(Workout $workout)
    {
        $Data = array(
            'workout' => $workout,
            'id' => $workout->id,
            't' => $workout->getTime(),
            'route' => null,
            'next' => null,
            'prev' => null
        );

        if($workout->route_id > 0) {
            $Data['route'] = Route::find($workout->route_id)->name;
        }
        
        $prev = Workout::where('id','<',$workout->id)->whereUserId(Auth::user()->id)->max('id');
        if ( ! is_null($prev)) {
            $Data['prev'] = Workout::find($prev)->slug;
        }
        $next = Workout::where('id','>',$workout->id)->whereUserId(Auth::user()->id)->min('id');
        if ( ! is_null($next)) {
            $Data['next'] = Workout::find($next)->slug;
        }
        return view('workouts.show', $Data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Workout $workout
     * @param Request $request
     * @return view 
     * @todo: find a better way to handle mood and health
     */
    public function edit(Workout $workout, Request $request)
    {
        $Data = array();
        if($workout->user_id == $request->user()->id) {
            $Data['workout'] = $workout;
            $Data['routes'] = Route::getAllInArray();
            $Data['mood'] = $workout->mood;
            $Data['health'] = $workout->health;
            $Data['t'] = $workout->getTime();
            $Data['date'] = $workout->date->format('Y-m-d');
            
            return view('workouts.edit', $Data);
        } else {
            return view('workouts.index')->with('message', trans('jrl.workout_not_authorized'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Workout $workout, Request $request)
    {
        $this->validate($request, $this->rules);
        $input = array_except($request->all(), '_method');
        if(!array_key_exists('finished', $input)) {
            $input['finished'] = 0;
        }
        $workout->update($input);
        return Redirect::route('workouts.show',$workout->slug)->with('message',trans('jrl.workout_saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Workout  $workout
     * @param Request $request
     * @return Redirect
     */
    public function destroy(Workout $workout, Request $request)
    {
        if($workout->user_id == $request->user()->id)
        {
            $workout->delete();
            return Redirect::route('workouts.index')->with('message',trans('jrl.workout_deleted'));
        } else {
            return Redirect::route('workouts.index')->with('message',trans('jrl.workout_not_authorized'));
        }
    }
    
    /**
     * Retrieve all Waypoints
     */
    public function waypoints(Request $request)
    {
        $id = $request->get('id');
        return Workout::find($id)->waypoints;
    }
    /*
     * Parse an uploaded .gpx file into a workout and its trackpoints.
     * 
     * @param void
     * @return Redirect
     */
    public function parse(Request $request)
	{
        $file = $request->get('file');
        $arrVal = array('file' => $file);
        $validator = Validator::make($arrVal,[
            'file' => ['required','mimes:xml,gpx']
        ]);

        if($validator->fails()) {
            return Redirect::to('upload')->withInput()->withErrors($validator);
        }
  
        $destinationPath = base_path() . '/public/tmp/';
        $extension = $file->getClientOriginalExtension();
        $fileName = $file->getFileName().'.'.$extension;
        $file->move($destinationPath, $fileName);
        $json = json_encode(simplexml_load_file($destinationPath.$fileName));
        $data = json_decode($json);

        $trkseg = $data->trk->trkseg->trkpt;

        // Calculate an approximate distance in kilometers
        $distance = 0;
        $lastLon = null;
        $lastLat = null;
        // Also: calculate moving time
        $moving_time = 0;
        $lastTs = null;
        foreach($trkseg as $pt) {
            $lat = $pt->{'@attributes'}->lat;
            $lon = $pt->{'@attributes'}->lon;
            $ts = $pt->time;

            if(!is_null($lastLon) && !is_null($lastLat)) {    
                // Was there movement?
                if( $lat != $lastLat || $lon != $lastLon ) {
                    $moving_time += Carbon::parse($ts)->diffInSeconds(Carbon::parse($lastTs));
                    $distance += $this->_calcDistance($lat, $lon, $lastLat, $lastLon);
                }
            }
            $lastLon = $lon;
            $lastLat = $lat;
            $lastTs = $ts;
        }
        $distance = round($distance,2);

        // Start calculating elapsed time
        $first = $trkseg[0];
        $last = array_pop($trkseg);
        
        // GPX has its times stored in the UTC time zone. Convert it to your own.
        // Make sure that it is set in app/config.php!
        $tz = Config::get('app.timezone');
        $ts = Carbon::parse($first->time,'UTC');
        $ts->setTimezone($tz);
        
        // Try to determine a name. This fallback makes some sense
        $name = "GPX Import ".$ts->format('Y-m-d');
        // Strava exports GPX thus:
        if(property_exists($data->trk, "name")) {
            $name = $data->trk->name;
        } else if(property_exists($data->metadata, "name")) {
            // MeeRun puts its name in the metadata
            $name = $data->metadata->name;
        }
        
        $workout = new Workout();
        $workout->name = $name;
        $workout->date = $ts->format('Y-m-d');
        $workout->user_id = Auth::user()->id;
        $workout->distance = $distance;
        $workout->start_time = $ts->format('H:i:s');
        $workout->time_in_seconds = $moving_time;
        $workout->lat_start = $first->{'@attributes'}->lat;
        $workout->lon_start = $first->{'@attributes'}->lon;
        $workout->lat_finish = $last->{'@attributes'}->lat;
        $workout->lon_finish = $last->{'@attributes'}->lon;
        $workout->save();
        
        $workout_id = $workout->id;
        
        $arrWps = array();
        foreach($trkseg as $t){
            $arrWps[] = array(
                'workout_id' => $workout_id,
                'timestamp' => $t->time,
                'lon' => $t->{'@attributes'}->lon,
                'lat' => $t->{'@attributes'}->lat,
            );
        }
        DB::table('waypoints')->insert($arrWps);
            
        $workout = Workout::find($workout_id);
        // Dirty hack. Please refactor if needed
        return Redirect::to('workouts/'.$workout->slug.'/edit');
	}

    /**
     * Calculate the distance between two points in kilometers
     * Because fuck the imperial system :-P
     * 
     * Source: http://stackoverflow.com/questions/27928/how-do-i-calculate-distance-between-two-latitude-longitude-points
     * 
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return $km : Distance in kilometers
     */
    private function _calcDistance($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return $km;
    }
}
