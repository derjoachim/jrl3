<?php namespace App\Http\Controllers;

use Auth;
use App\Workout;
use App\Repositories\RoutesRepository;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $oRouteRepo = new RoutesRepository();
        $Data = [];
        $Data['favorite_routes'] = $oRouteRepo->favorites();
        $Data['latest_workouts'] = Workout::latest('date')
            ->whereUserId(Auth::user()->id)
            ->take(5)->get();
		return view('home', $Data);
	}

}
