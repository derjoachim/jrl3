<?php

namespace App\Models;

use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = ['id'];
    
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    
    public function workouts()
    {
        return $this->hasMany('App\Models\Workout');
    }
    
    
    public function getOrSetStoragePath()
    {
        $strPathByUser = $this->user_id. DIRECTORY_SEPARATOR . $this->id;
        if( ! Storage::disk('local')->exists($strPathByUser)) {
            Storage::makedirectory($strPathByUser);
        }
        return $strPathByUser;
    }
}
