<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class FitnessService extends Model
{
    use Sluggable;
    protected $guarded = ['id'];
    public $timestamps = false;
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
    
    public function users()
    {
        return $this->hasMany('App\Models\User', 'fitness_services_users');
    }
    
    public function workouts()
    {
        return $this->hasMany('App\Models\Workout', 'workouts_fitness_services');
    }
}
