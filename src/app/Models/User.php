<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract 
    {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function routes() 
    {
        return $this->hasMany('App\Models\Route');
    }
    
    public function workouts()
    {
        return $this->hasMany('App\Models\Workout');
    }
    
    public function fitness_services()
    {
        return $this->hasMany('App\Models\FitnessService','fitness_services_users');
    }
    
    
    public function logs()
    {
        return $this->hasMany('App\Models\Log');
    }
}
