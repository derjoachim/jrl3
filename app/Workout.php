<?php namespace Jrl3;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Workout extends Model implements SluggableInterface {

    protected $guarded = ['id'];

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'date',
        'save_to'    => 'slug',
        'on_update'  => false,
    );

}
