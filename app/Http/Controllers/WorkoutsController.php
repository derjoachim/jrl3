<?php namespace Jrl3\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Config; 
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Input;
use Jrl3\Workout;
use Jrl3\Route;
use Jrl3\Waypoint;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Redirect;
use Validator;

class WorkoutsController extends Controller {

    protected $rules = [
        'date' => ['required','date'],
        'name' => ['required','min:3'],
        'description' => ['required','min:10']
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
    public function index()
    {
        $workouts = Workout::latest('date')->get();
        $routes = $this->_getRoutes();
        
        // @TODO: This is a quick 'n dirty solution. There probably a better
        // solution
        foreach( $workouts as $workout) {
            $workout->time = $workout->getTime('time_in_seconds');
            $workout->route = $workout->route_id ? $routes[$workout->route_id] : 'geen';
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
        $routes = $this->_getRoutes($request);
        $date = date("Y-m-d");
        return view('workouts.create',compact('routes','date'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Jrl3\Workout $workout
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Workout $workout, Request $request)
    {
        $this->validate($request, $this->rules);
        $input = Input::all();
        $workout = new Workout($input);
        Auth::user()->workouts()->save($workout);

        return Redirect::route('workouts.index')->with('message', 'Nieuwe workout opgeslagen');
    }

    /**
     * Display the specified resource.
     *
     * @param  Workout $workout
     * @return Response
     */
    public function show(Workout $workout)
    {
        $t = $workout->getTime();
        $id = $workout->id;
        $route = null;
        if($workout->route_id > 0) {
            $route = Route::find($workout->route_id)->name;
        }
        return view('workouts.show', compact('workout','t','route','id'));
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
        if($workout->user_id == $request->user()->id) {
            $routes = $this->_getRoutes($request);
            $mood = $workout->mood;
            $health = $workout->health;
            $t = $workout->getTime();
            $date = $workout->date->format('Y-m-d');
            
            return view('workouts.edit', compact('workout','routes','mood','health','t','date'));
        } else {
            return view('workouts.index')->with('message', 'U heeft niet de juiste rechten om deze workout te bewerken.');
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
        $input = array_except(Input::all(), '_method');
        if(!array_key_exists('finished', $input)) {
            $input['finished'] = 0;
        }
        $workout->update($input);
        return Redirect::route('workouts.show',$workout->slug)->with('message','De workout is bijgewerkt.');
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
            return Redirect::route('workouts.index')->with('message','De workout is verwijderd');
        } else {
            return Redirect::route('workouts.index')->with('message','U heeft niet de rechten om deze route te verwijderen');
        }
    }
    /*
     * Parse an uploaded file into a workout and its trackpoints.
     * 
     * @param void
     * @return Redirect
     */
    public function parse()
	{
        $file = Input::file('file');
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
        $first = $trkseg[0];
        $last = array_pop($trkseg);
        
        // GPX has its times stored in the UTC time zone. Convert it to your own.
        // Make sure that it is set in app/config.php!
        $tz = Config::get('app.timezone');
        $ts = Carbon::parse($first->time,'UTC');
        $ts->setTimezone($tz);
        
        // Calculate the elapsed time
        $elapsed_time = Carbon::parse($last->time)->diffInSeconds(Carbon::parse($first->time));
  
        // @TODO: Calculate moving time?
        
        // @TODO: Refactor into Eloquent. This will make slugging somewhat easier.
        $workout_id = DB::table('workouts')->insertGetId(
            array(
                'name' => $data->trk->name,
                'date' => $ts->format('Y-m-d'),
                'slug' => $ts->format('Y-m-d').'-'.'gpx-import', 
                'user_id' => Auth::user()->id,
                'start_time' => $ts->format('H:i:s'),
                'time_in_seconds' => $elapsed_time,
                'lat_start' => $first->{'@attributes'}->lat,
                'lon_start' => $first->{'@attributes'}->lon,
                'lat_finish' => $last->{'@attributes'}->lat,
                'lon_finish' => $last->{'@attributes'}->lon,
                'created_at' => Carbon::now(),
        ));
        
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
            
        $workout = DB::table('workouts')->where('id', '=', $workout_id)->first();
        // @TODO: Dirty hack. Please refactor
        return Redirect::to('workouts/'.$workout->slug.'/edit');
	}
    /*
     * Get all waypoints by route_id
     * @param integer id : id of the route
     * @return json
     */
    public function waypoints(Request $request)
    {
        $id = $request->input('id');
        if(is_numeric($id)) {
            return Workout::find($id)->waypoints;
        } else {
            // @TODO: Foutafhandeling
        }
    }
    /**
     * Helper function to retrieve all routes
     * 
     * @param void
     * @return array arrRoute
     * @TODO: Retrieve by userid
     * @TODO: Not sure whether this should be in the controller. Refactor if necessary.
     */
    private function _getRoutes()
    {
        return array('' => '--- Geen route ---') + Route::lists('name','id');
    }
}
