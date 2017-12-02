<?php

namespace App\Models;

use Auth;
use App\Events\LogDeleting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = ['id'];
    
    protected $events = ['deleting' => LogDeleting::class];
    
    public function user()
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
    
    public function getFullPath()
    {
        return storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $this->path;
    }
    
    
    public function getParentDirectory()
    {
        return Auth::id() . DIRECTORY_SEPARATOR . $this->id;
    }
}
