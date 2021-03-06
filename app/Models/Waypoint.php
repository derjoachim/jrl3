<?php namespace App\Models;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Model;

final class waypoint extends Model {
    protected $guarded = ['id'];
	//
    public function workout() 
    {
        return $this->belongsTo('App\Models\Workout','workout_id');
    }
    
    public function ScopegetByWorkoutId($id)
    {
        if(is_numeric($id)) {
            return Workout::find($id)->waypoints;//->waypoints;
        }
        return null;
    }
}
