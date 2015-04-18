<?php namespace Jrl3\Http\Controllers;

use Jrl3\Workout;
use Jrl3\Route;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Input;
use Redirect;
use Illuminate\Http\Request;

class WorkoutsController extends Controller {

    protected $rules = [
        'date' => ['required','date'],
        'name' => ['required','min:3'],
        'description' => ['required','min:10']
    ];

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
    public function create()
    {
        $routes = $this->_getRoutes();
        //echo '<pre>'.print_r($routes,true).'</pre>';exit;
        
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
        Workout::create( $input );

        return Redirect::route('workouts.index')->with('message', 'Nieuwe workout opgeslagen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
            //
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
     */
    private function _getRoutes()
    {
        $routes = Route::all();
        
        $arrRoute = array('' => '-- Geen standaardroute --');
        foreach ( $routes as $route):
            $arrRoute[$route->id] = $route->name.' ('.$route->distance.' km)';
        endforeach;
        return $arrRoute; // @TODO: by userid
    }
}
