<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


final class Workout extends Model
{
    
    protected $guarded = ['id'];
    
    protected $dates = ['date'];
    
    use Sluggable;
    
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
    
    /*
     * Times are saved in seconds. This method converts this value in a readable 
     * format
     * @param $fld string : attribute key
     * @return string HH:ii:ss
     */
    public function getTime($fld = 'time_in_seconds')
    {
        $secs = $this->attributes[$fld];
        $t = ($secs > 3600 ? 'H:' : '').'i:s';
        return gmdate($t, $secs);
    }
    
    /**
     * Calculate and render average minutes per kilometer
     *
     * @return string
     */
    public function getAvg(): string
    {
        return gmdate('i:s', ($this->time_in_seconds / $this->distance));
    }
    
    public function setTimeInSecondsAttribute($time)
    {
        $this->attributes['time_in_seconds'] = $this->_time_to_seconds($time);
    }
    
    public function route()
    {
        return $this->belongsTo('App\Models\Route', 'route_id');
    }
    
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function waypoints()
    {
        return $this->hasMany('App\Models\Waypoint');
    }
    
    public function fitness_services() // Rename?
    {
        return $this->hasOne('App\Models\FitnessService', 'workouts_fitness_services');
    }
    
    public function workouts_fitness_services()
    {
        return $this->hasOne('App\Models\WorkoutsFitnessServices');
    }
    
    private function _time_to_seconds($time)
    {
        $arTime = array_reverse(explode(':', $time));
        $seconds = 0;
        foreach ($arTime as $idx => $num) {
            $seconds += ($num * pow(60, $idx));
        }
        return $seconds;
    }
}
