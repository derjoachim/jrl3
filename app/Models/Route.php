<?php namespace App\Models;

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
        $myRoutes = self::whereUserId(Auth::user()->id)->lists('name','id');
        return array('' => '--- ' . trans('jrl.no_route') . ' ---') + $myRoutes->toArray();
    }
}
