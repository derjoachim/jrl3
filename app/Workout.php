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
        return $this->attributes['date'] . ' ' . $this->name;
    }
    
    public function setDateAttribute($date) 
    {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /*
     * Times are saved in seconds. One day, I created a beautiful Python oneliner
     * for such a case, but alas, this is PHP. Ugly code it is. Will refactor later
     * to a presenter. 
     */
    public function getTimeInSeconds($fld = 'time_in_seconds')
    {
        $secs = $this->attributes[$fld];
        $hrs = floor($secs / 3600);
        $secs -= ($hrs * 3600);
        $mins = floor($secs / 60);
        $secs -= ($mins * 60);
        
        $t = '';
        if($hrs > 0) {
            $t .= $hrs.':';
        }
        if($mins > 0) {
            $t .= ($mins < 10 ? '0'.$mins : $mins).':';
        }
        $t .= $secs;
        
        return $t;       
    }
    
    public function setTimeInSecondsAttribute($time)
    {
        $this->attributes['time_in_seconds'] = $this->_time_to_seconds($time);
    }
    
    public function route()
    {
        return $this->belongsTo('Jrl3\Route','route_id');
    }

    public function users()
    {
        return $this->belongsTo('Jrl3\User');
    }
    
    private function _time_to_seconds($time)
    {
        $arTime = array_reverse(explode(':',$time));
        $seconds = 0;
        foreach( $arTime as $idx => $num) {
            $seconds += ($num * pow(60,$idx));
        }
        return $seconds;
    }
}
