<?php namespace Jrl3;

use Illuminate\Database\Eloquent\Model;

class waypoint extends Model {

	//
    public function workout() 
    {
        return $this->belongsTo('Jrl3\Workout','workout_id');
    }
}
