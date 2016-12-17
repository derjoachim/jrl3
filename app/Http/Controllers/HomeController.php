<?php namespace App\Http\Controllers;

use Auth;
use App\Route;
use App\Workout;
use App\Repositories\RoutesRepository;
use App\Repositories\WorkoutsRepository;

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
        $oRoutesRepo = new RoutesRepository();
        $oWorkoutsRepo = new WorkoutsRepository();
        $arTotals = [
            'by_year' => $oWorkoutsRepo->getByPeriod('year'),
            'by_month' => $oWorkoutsRepo->getByPeriod('month'),
            'by_week' => $oWorkoutsRepo->getByPeriod('week'),
        ];
        $Data = [];
        $Data['cumulative_workouts'] = $oWorkoutsRepo->calcNumWorkouts($arTotals);
        $Data['cumulative_distance'] = $oWorkoutsRepo->calcDistance($arTotals);
        $Data['grand_totals'] = [
            'num_workouts' => $oWorkoutsRepo->totalWorkouts(),
            'total_distance' => $oWorkoutsRepo->totalDistance(),
            'num_routes' => Route::whereUserId(Auth::user()->id)->count()
        ];

        $Data['favorite_routes'] = $oRoutesRepo->favorites();
        $Data['latest_workouts'] = Workout::latest('date')
            ->whereUserId(Auth::user()->id)
            ->take(5)->get();
		return view('home', $Data);
	}

}
