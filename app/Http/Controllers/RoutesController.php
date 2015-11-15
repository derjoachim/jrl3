<?php namespace Jrl3\Http\Controllers;

use Jrl3\Route;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Input;
use Redirect;
use Illuminate\Http\Request;
use Auth;

class RoutesController extends Controller {

    /**
     * Array of validation rules
     * 
     */
    protected $rules = [
        'name'          => ['required','min:3'],
        'description'   => ['required','min:10']
    ];
    
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
        $routes = Route::whereUserId(Auth::user()->id)->get();
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
        $route = new Route($input);
        Auth::user()->routes()->save($route);
 
        return Redirect::route('routes.index')->with('message', trans('jrl.route_saved'));
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
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function edit(Route $route, Request $request)
    {
        if($route->user_id == $request->user()->id)
        {
            return view('routes.edit', compact('route'));
        } else {
            return Redirect::route('routes.index')->with('message',trans('app.route_not_authorized'));
        }
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

        return Redirect::route('routes.show',$route->slug)->with('message',trans('jrl.route_saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function destroy(Route $route, Request $request)
    {
        if($route->user_id == $request->user()->id)
        {
            $route->delete();
            return Redirect::route('routes.index')->with('message',trans('jrl.route_deleted'));
        } else {
            return Redirect::route('routes.index')->with('message',trans('app.route_not_authorized'));
        }
    }
    
    /**
     * Retrieve route data as JSON
     * @param int $id
     * @return jsonresponse
     */
    public function getById(Request $request)
    {
        $id = $request->input('id');
        if(is_numeric($id)) {
            return Route::find($id);
        } else {
            // @TODO: Foutafhandeling
        }
    }


}
