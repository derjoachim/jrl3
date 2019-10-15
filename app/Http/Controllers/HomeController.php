<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoutesRepository;
use App\Repositories\WorkoutsRepository;
use App\Models\Route;
use App\Models\Workout;
use Auth;
use App\Repositories\StravaServiceRepository;

final class HomeController extends Controller
{
    
    private $repo;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StravaServiceRepository $oRepo)
    {
        $this->repo = $oRepo;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('code')) {
            $this->repo->getToken($request);
        }
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
            'num_routes' => Route::whereUserId(Auth::id())->count()
        ];

        $Data['favorite_routes'] = $oRoutesRepo->favorites();
        $Data['latest_workouts'] = Workout::latest('date')
            ->whereUserId(Auth::id())
            ->take(5)->get();
        return view('home', $Data);
    }
}
