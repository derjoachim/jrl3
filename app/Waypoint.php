<?php namespace App;
use App\Workout;
use Illuminate\Database\Eloquent\Model;

class waypoint extends Model {
    protected $guarded = ['id'];
	//
    public function workout() 
    {
        return $this->belongsTo('App\Workout','workout_id');
    }
    
    public function ScopegetByWorkoutId($id)
    {
        if(is_numeric($id)) {
            return Workout::find($id)->waypoints;//->waypoints;
        }
        return null;
    }
}
