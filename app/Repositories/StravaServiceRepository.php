<?php namespace Jrl3\Repositories;

use cURL;

use DB;
use Jrl3\Repositories\ServicesRepository;

class StravaServiceRepository extends ServicesRepository
{
    public function __construct($name = 'strava')
    {
        parent::__construct($name);
    }
    
    public function latest()
    {
        return cURL::newRequest('get', 'https://www.strava.com/api/v3/'.
            '/athlete/activities',['per_page'=>'1'])
            ->setHeader('Authorization: ','Bearer '.$this->getKey())
            ->setHeader('content-type', 'application/json')
            ->setHeader('Accept', 'json')
            ->setOptions([CURLOPT_VERBOSE => true])
            ->send();
    }
    
    public function getKey()
    {
        return $this->api_key;
    }
    
    public function import($id) {
        return cURL::newRequest('get','https://www.strava.com/api/v3/'.
            '/activities/'.$id)
            ->setHeader('Authorization: ','Bearer '.$this->getKey())
            ->setHeader('content-type', 'application/json')
            ->setHeader('Accept', 'json')
            ->setOptions([CURLOPT_VERBOSE => true])
            ->send();
    }
}