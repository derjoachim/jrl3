<?php namespace Jrl3;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class FitnessService extends Model implements SluggableInterface {

    protected $guarded = ['id'];

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
        'on_update'  => true,
    );
    
    public function users()
    {
        return $this->hasMany('Jrl3\User','fitness_services_users');
    }
    
    public function workouts()
    {
        return $this->hasMany('Jrl3\Workout','workouts_fitness_services');
    }
}
