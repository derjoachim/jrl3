<?php namespace App\Repositories;

use GuzzleHttp\Client;

use DB;
use App\Models\FitnessService;
use App\Repositories\ServicesRepository;

class StravaServiceRepository extends ServicesRepository
{
    public function __construct($name = 'strava')
    {
        parent::__construct($name);
    }
    
    public function latest()
    {
        $client = $this->_getClient();
        $res = $client->request('GET', '/api/v3/athlete/activities', ['query' => ['per_page' => 10]]);
        if($res->getStatusCode() == 200) {
            return $res->getBody()->getContents();
        } else {
            // @TODO!
            return false;
        }
    }


    public function import($id) {
        $client = $this->_getClient();
        $res = $client->request('GET', '/api/v3/activities/' . $id );
        if($res->getStatusCode() == 200) {
            return $res->getBody()->getContents();
        } else {
            // @TODO!
        }

//        return cURL::newRequest('get','https://www.strava.com/api/'.
//            '/activities/'.$id)
//            ->setHeader('Authorization: ','Bearer '.$this->getKey())
//            ->setHeader('content-type', 'application/json')
//            ->setHeader('Accept', 'json')
//            ->setOptions([CURLOPT_VERBOSE => true])
//            ->send();
    }
    
    
    public function getKey()
    {
        return $this->api_key;
    }
    
    public function getWorkoutId($id) 
    {
        $wfs = DB::table('workouts_fitness_services')
            ->where('fitness_service_id','=',$this->service_id)
            ->where('fitness_service_remote_identifier','=',$id)->first();
        if( $wfs ) {
            return $wfs->workout_id;
        }
        return null;
    }
    
    
    private function _getClient()
    {
        return new \GuzzleHttp\Client(
            ['base_uri' => 'https://www.strava.com/',
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getKey(),
                    'content-type' => 'application/json',
                    'Accept' => 'json',
                ],
                
                'connect_timeout' => 10,
                'timeout' => 10
            ]
        );
    }
}