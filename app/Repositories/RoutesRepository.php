<?php namespace App\Repositories;

use App\Route;
use Auth;
use DB;

class RoutesRepository
{
    /**
     * Get favorite routes by number of workouts
     * 
     * This method shows my love for eloquent!
     * 
     * @param integer $iNumFavorites number of results to retrieve
     * @return collection
     */
    public function favorites($iNumFavorites=5)
    {
        return Route::whereUserId(Auth::user()->id)
            ->withCount('workouts')
            ->orderBy('workouts_count','desc')
            ->take($iNumFavorites)
            ->get();
    }
}