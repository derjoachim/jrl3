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
        'on_update'  => true,
    );

    public function getEntryAttribute() 
    {
        $dt = Carbon::parse($this->attributes['date']);
        $strdt = $dt->year.'-'.($dt->month < 10 ? '0': '').$dt->month.'-'.
            ($dt->day < 10 ? '0' : '').$dt->day;
        return $strdt. ' ' . $this->name;
    }
    
    public function setDateAttribute($date) 
    {
        $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $date);
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
        $t = ($secs > 3600 ? 'H:' : '') . 'i:s';
        return gmdate($t, $secs);
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
    
    public function waypoints()
    {
        return $this->hasMany('Jrl3\Waypoint');
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
