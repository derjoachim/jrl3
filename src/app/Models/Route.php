<?php namespace App\Models;

use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;

final class Route extends Model {
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function workouts()
    {
        return $this->hasMany('App\Models\Workout', 'route_id');
    }
    
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
        
    public static function getAllInArray()
    {
        $myRoutes = self::whereUserId(Auth::user()->id)->pluck('name','id');
        return array('' => '--- ' . trans('jrl.no_route') . ' ---') + $myRoutes->toArray();
    }
    
    public function getPR()
    {
        $strPR = null;
        $oWorkout = Workout::whereUserId(Auth::id())->whereRouteId($this->id)
            ->where('time_in_seconds','>',0)
            ->orderBy('time_in_seconds')->first();
        if(!empty($oWorkout)) {
            $strPR = $oWorkout->getTime() . ' - ' . Carbon::parse($oWorkout->date, Config::get('app.timezone'))
                    ->format('d-m-Y');
        }
        return $strPR;
    }
    
    
    public function getLatestWorkouts(?int $iNumRecords = 5)
    {
        return $this->workouts()->latest('date')->take($iNumRecords)->get();
    }
    
    public function getFastestWorkouts(?int $iNumRecords = 5)
    {
        return $this->workouts()->where('time_in_seconds', '>',0)
            ->orderBy('time_in_seconds')->take($iNumRecords)->get();
    }
}
