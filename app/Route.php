<?php namespace Jrl3;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Route extends Model implements SluggableInterface {

    protected $guarded = ['id'];

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
        'on_update'  => true,
    );
    
    public function workouts()
    {
        return $this->hasMany('Jrl3\Workout');
    }
    
    public function users()
    {
        return $this->belongsTo('Jrl3\User');
    }
    
    public static function getAllInArray()
    {
        $myRoutes = self::whereUserId(Auth::user()->id)->lists('name','id');
        return array('' => '--- ' . trans('jrl.no_route') . ' ---') + $myRoutes->toArray();
    }
}
