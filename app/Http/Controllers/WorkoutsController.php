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
        return view('workouts.show', compact('workout'))->with('t',$workout->getTime());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  
     * @return Response
     */
    public function edit(Workout $workout, Request $request)
    {
        if($workout->user_id == $request->user()->id) {
            $routes = $this->_getRoutes($request);
            return view('workouts.edit', compact('workout'),compact('routes'))->with([
                'route_id' => $workout->route_id,
                'mood' => $workout->mood,
                'health' => $workout->health,
                't' => $workout->getTime()
                ]);
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
        $routes = Route::all();
        
        $arrRoute = array('' => '-- Geen standaardroute --');
        foreach ( $routes as $route):
            $arrRoute[$route->id] = $route->name.' ('.$route->distance.' km)';
        endforeach;
        return $arrRoute;
    }
}
