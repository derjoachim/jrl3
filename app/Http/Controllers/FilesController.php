<?php namespace Jrl3\Http\Controllers;

use Auth;
use DB;
use Validator;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Carbon\Carbon;
use Jrl3\Workout;
use Jrl3\Waypoint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Input;
use Redirect;
//use Carbon\Carbon;
class FilesController extends Controller {
    
    protected $rules = [
        'file' => ['required','mimes:xml,gpx']
    ];

    public function __construct() {
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function upload()
	{
		return view('files.upload');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function parse()
	{
        $file = Input::file('file');
        $arrVal = array('file' => $file);
        $validator = Validator::make($arrVal, $this->rules);
        if($validator->fails()) {
            return Redirect::to('upload')->withInput()->withErrors($validator);
        }
  
        $destinationPath = base_path() . '/public/tmp/';
        $extension = $file->getClientOriginalExtension();
        $fileName = $file->getFileName().'.'.$extension;
        $file->move($destinationPath, $fileName);
        $json = json_encode(simplexml_load_file($destinationPath.$fileName));
        $data = json_decode($json);

        $ts = new \DateTime($data->metadata->time);
        $trkseg = $data->trk->trkseg->trkpt;
        $last = array_pop($trkseg);

        // TODO: Calculate moving time.
        $workout_id = DB::table('workouts')->insertGetId(
            array(
                'name' => $data->trk->name,
                'date' => $ts->format('Y-m-d'),
                'slug' => $ts->format('Y-m-d').'-'.'gpx-import',
                'user_id' => Auth::user()->id,
                'start_time' => $ts->format('H:i:s'),
                'lat_start' => $trkseg[0]->{'@attributes'}->lat,
                'lon_start' => $trkseg[0]->{'@attributes'}->lon,
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
        // Dirty hack. Please refactor
        return Redirect::to('workouts/'.$workout->slug.'/edit');
	}
}
