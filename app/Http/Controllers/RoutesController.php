<?php namespace Jrl3\Http\Controllers;

use Jrl3\Route;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Input;
use Redirect;
use Illuminate\Http\Request;

class RoutesController extends Controller {

    protected $rules = [
        'name' => ['required','min:3'],
        //'slug' => ['required'],
        'description' => ['required','min:10']
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Jrl3\Route $route
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Route $route, Request $request)
    {
        $this->validate($request, $this->rules);
        $input = Input::all();
        Route::create( $input );

        return Redirect::route('routes.index')->with('message', 'Nieuwe route opgeslagen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Route $route)
    {
       return view('routes.show',compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Route $route)
    {
        return view('routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Jrl3\Route $route
     * @param \Illuminate\Http\Request $request
     * 
     * @return Response
     */
    public function update(Route $route, Request $request)
    {
        $this->validate($request, $this->rules);
        $input = array_except(Input::all(), '_method');
        $route->update($input);

        return Redirect::route('routes.show',$route->slug)->with('message','De route is opgeslagen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Route $route)
    {
        $route->delete();

        return Redirect::route('routes.index')->with('message','De route is verwijderd');
    }

}
