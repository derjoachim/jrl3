<?php namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Route extends Model {
    use Sluggable;

    protected $guarded = ['id'];

public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    public function workouts()
    {
        return $this->hasMany('App\Workout', 'route_id');
    }
    
    public function users()
    {
        return $this->belongsTo('App\User');
    }
        
    public static function getAllInArray()
    {
        $myRoutes = self::whereUserId(Auth::user()->id)->lists('name','id');
        return array('' => '--- ' . trans('jrl.no_route') . ' ---') + $myRoutes->toArray();
    }
}
