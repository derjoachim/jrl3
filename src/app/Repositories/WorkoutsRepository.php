<?php

namespace App\Repositories;

use App\Models\Workout;
use Auth;
use Carbon\Carbon;

class WorkoutsRepository
{
    public $user_id;
    public $allWorkoutsByUser;
    public function __construct()
    {
        $this->user_id = Auth::user()->id;
        $this->allWorkoutsByUser = Workout::whereUserId($this->user_id)->get();
    }
    /**
     * Get workouts by a specified period
     * 
     * This wrapper function gets the latest workouts for the selected period.
     * 
     * @param type $strPeriod ['year','month','week']
     * @return mixed: 
     */
    public function getByPeriod($strPeriod)
    {
        switch(strtolower($strPeriod)){
            case 'year':
                return $this->getByYear();
            case 'month':
                return $this->getByMonth();
            case 'week':
                return $this->getByWeek();
        }
        return [];
    }
    
    public function getByYear()
    {
        $oCarbon = new Carbon();
        $now = $oCarbon->now();
        $startOfYear = $now->startOfYear();
        $result = $this->allWorkoutsByUser->filter(function($value, $key) use($startOfYear) {
            return $value->date >= $startOfYear;
        });
        return $result->all();
    }
     
    public function getByMonth()
    {
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $result = $this->allWorkoutsByUser->filter(function($value, $key) use($startOfMonth) {
            return $value->date >= $startOfMonth;
        });
        return $result->all();
    }
    
    
    public function getByWeek()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek();
        $result = $this->allWorkoutsByUser->filter(function($value, $key) use($startOfWeek) {
            return $value->date >= $startOfWeek;
        });
        return $result->all();
    }
    
    
    /**
     * Count distance by period
     * 
     * @param array $arrParam
     * @return array cumulative distance 
     */
    public function calcDistance(array $arrParam)
    {
        $arRet = [];
        foreach ($arrParam as $key => $val) {
            $arRet[$key] = collect($val)->sum('distance');
        }
        return $arRet;
    }
    
    
    /**
     * Count workouts by period
     * 
     * @param array $arrParam
     * @return array cumulative number of workouts by period
     */
    public function calcNumWorkouts(array $arrParam)
    {
        $arRet = [];
        foreach ($arrParam as $key => $val) {
            $arRet[$key] = count($val);
        }
        return $arRet;
    }
    
    /**
     * Return ALL workouts by user
     * 
     * @param none
     * @return type
     */
    public function totalWorkouts()
    {
        return $this->allWorkoutsByUser->count();
    }
    
    
    /**
     * Calculate the total distance for ALL users
     * 
     * @param none
     * @return type
     */
    public function totalDistance()
    {
        return $this->allWorkoutsByUser->sum('distance');
    }
}