<?php namespace Jrl3\Http\Controllers;

use Jrl3\Workout;
use Jrl3\Route;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Input;
use Redirect;
use Illuminate\Http\Request;
use Auth;

class WorkoutsController extends Controller {
    /*
     * Validation rules. @TODO: 'time_in_seconds'
     */
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
     * @return Response
     */
    public function index()
    {
        $workouts = Workout::latest('date')->get();
        
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
        return view('workouts.create',compact('routes'));
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
        //Workout::create( $input );
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
        return view('workouts.show', compact('workout'))->with('t',$workout->getTimeInSecondsAttribute());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
            //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
            //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
            //
    }
    
    /**
     * Helper function to retrieve all routes
     * 
     * @param void
     * @return array arrRoute
     * @TODO: Retrieve by userid
     * @TODO: Not sure whether this should be in the controller. Refactor if necessary.
     */
    private function _getRoutes(Request $request)
    {
        $routes = Route::all();
        
        $arrRoute = array('' => '-- Geen standaardroute --');
        foreach ( $routes as $route):
            $arrRoute[$route->id] = $route->name.' ('.$route->distance.' km)';
        endforeach;
        return $arrRoute;
    }
    
    /**
     * @TODO: Time in Seconds >> Time
     * Not sure whether controller action
     */
    
    /**
     * @TODO: Time >> Time in Seconds
     * Not sure whether controller action
     */
}
