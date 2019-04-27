<?php namespace App\Repositories;

use GuzzleHttp\Client as Guzzle;
use Config;
use DB;
use Strava\API\{OAuth, Exception, Client};
use Strava\API\Service\REST;

final class StravaServiceRepository extends ServicesRepository
{
    
    private $token = null;
    
    public function __construct($name = 'strava')
    {
        parent::__construct($name);
        $this->_getToken();
    }
    
    public function latest()
    {
        /*
         * // REST adapter (We use `Guzzle` in this project)
$adapter = new \GuzzleHttp\Client(['base_uri' => 'https://www.strava.com/api/v3']);
// Service to use (Service\Stub is also available for test purposes)
$service = new Service\REST('RECEIVED-TOKEN', $adapter);

// Receive the athlete!
$client = new Client($service);
$athlete = $client->getAthlete();
print_r($athlete);
         */
        $client = $this->_getClient();
        $res = $client->request('GET', '/api/v3/athlete/activities', ['query' => ['per_page' => 10]]);
        if ($res->getStatusCode() == 200) {
            return $res->getBody()->getContents();
        } else {
            // @TODO!
            return false;
        }
    }
    
    
    public function import($id)
    {
        $client = $this->_getClient();
        $res = $client->request('GET', '/api/v3/activities/' . $id);
        if ($res->getStatusCode() == 200) {
            return $res->getBody()->getContents();
        } else {
            // @TODO!
        }
    }
    
    
    public function getKey()
    {
        return $this->api_key;
    }
    
    public function getWorkoutId($id)
    {
        $wfs = DB::table('workouts_fitness_services')
            ->where('fitness_service_id', '=', $this->service_id)
            ->where('fitness_service_remote_identifier', '=', $id)->first();
        if ($wfs) {
            return $wfs->workout_id;
        }
        return null;
    }
    
    
    private function _getToken()
    {
        try {
            $options = [
                'clientId'     => env('STRAVA_CLIENT_ID'),
                'clientSecret' => env('STRAVA_CLIENT_SECRET'),
                'redirectUri'  => env('APP_URL')
            ];
            $oauth = new OAuth($options);
        
            if (!isset($_GET['code'])) {
                // eek! Todo!
                print '<a href="'.$oauth->getAuthorizationUrl([
                        // Uncomment required scopes.
                        'scope' => [
                            'public',
                            // 'write',
                            // 'view_private',
                        ]
                    ]).'">Connect</a>';
            } else {
                $token = $oauth->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
                $this->token = $token->getToken();
//                print $token->getToken();
            }
        } catch(Exception $e) {
            Log::warning( $e->getMessage());
        }
    }
    
    private function _getClient()
    {
        return new Client(
//            ['base_uri' => 'https://www.strava.com/',
//                'headers' => [
//                    'Authorization' => 'Bearer ' . $this->getKey(),
//                    'content-type' => 'application/json',
//                    'Accept' => 'json',
//                ],
//
//                'connect_timeout' => 10,
//                'timeout' => 10
//            ]
        );
    }
}