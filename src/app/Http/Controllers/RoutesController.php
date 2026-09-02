<?php

namespace App\Http\Controllers;

use App;
use App\Models\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Lang;

final class RoutesController extends Controller {

    /**
     * Array of validation rules
     * 
     */
    protected $rules = [
        'name' => ['required', 'min:3'],
        'description' => ['required', 'min:10']
    ];

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        $routes = Route::whereUserId(Auth::user()->id)->get();
//        $routes = $request->user()->routes; // TODO: This should work, yet doesn't. Why?
        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Models\Route $route
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, $this->rules);
        $input = $request->all();
        $route = new Route($input);
        $route->user_id = Auth::id();
        $route->save();
//        $request->user()->routes->save($route); // @TODO: this should work. Why not now?

        return Redirect::route('routes.index')->with('message', trans('jrl.route_saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Route $route) {
        if($route->user_id !=  Auth::id()) {
            return Redirect::route('routes.index')->withMessage( Lang::get('jrl.route_not_authorized'));
        }
        $Data = array();
        $Data['route'] = $route;
        $Data['pr'] = $route->getPR();
        $Data['latest_workouts'] = $route->getLatestWorkouts();
        $Data['fastest_workouts'] = $route->getFastestWorkouts();
        return view('routes.show', $Data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function edit(Route $route, Request $request) {
        if ($route->user_id == $request->user()->id) {
            return view('routes.edit', compact('route'));
        } else {
            return Redirect::route('routes.index')->with('message', trans('app.route_not_authorized'));
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \App\Models\Route $route
     * @param \Illuminate\Http\Request $request
     * 
     * @return Response
     */
    public function update(Route $route, Request $request) {
        $this->validate($request, $this->rules);
        $input = array_except($request->all(), '_method');
        $route->update($input);

        return Redirect::route('routes.show', $route->slug)->with('message', trans('jrl.route_saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function destroy(Route $route, Request $request) {
        if ($route->user_id == $request->user()->id) {
            $route->delete();
            return Redirect::route('routes.index')->with('message', trans('jrl.route_deleted'));
        } else {
            return Redirect::route('routes.index')->with('message', trans('jrl.route_not_authorized'));
        }
    }

    /**
     * Retrieve route data as JSON
     * @param int $id
     * @return jsonresponse
     */
    public function getById(Request $request) {
        $id = $request->input('id');
        if (is_numeric($id)) {
            return Route::find($id);
        } else {
            // @TODO: Foutafhandeling
        }
    }

}
