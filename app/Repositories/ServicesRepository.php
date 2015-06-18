<?php namespace Jrl3\Repositories;

use Auth;
use DB;
use Jrl3\Repositories\Contracts\FitnessServicesInterface;

abstract class ServicesRepository implements FitnessServicesInterface
{
    public $service_id;
    public $service_name;
    public $api_key;
    public $service_user_id;

    public function __construct($name)
    {
        $srv = DB::table('fitness_services')->where('slug',$name)->first();
        $this->service_id = $srv->id;
        $this->service_name = $name;
        $this->api_key = $srv->api_key;
        $this->service_user_id = DB::table('fitness_services_users')
            ->where('user_id',Auth::user()->id)
            ->where('fitness_service_id',$this->service_id)
            ->pluck('service_user_id');
    }
    
    abstract function latest();
    
    abstract function getKey();
    
    abstract function import($id);
}