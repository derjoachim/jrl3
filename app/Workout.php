<?php namespace Jrl3;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Workout extends Model implements SluggableInterface {

    protected $guarded = ['id'];
    
    protected $dates = ['date'];
    
    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'entry',
        'save_to'    => 'slug',
        'on_update'  => false,
    );

    public function getEntryAttribute() 
    {
        return $this->date . ' ' . $this->name;
    }
    
    public function setDateAttribute($date) 
    {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
    }
    
    public function route()
    {
        return $this->belongsTo('Jrl3\Route','route_id');
    }

    public function users()
    {
        return $this->belongsTo('Jrl3\User');
    }

}
