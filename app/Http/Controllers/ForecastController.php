<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Log;

use Illuminate\Http\Request;

final class ForecastController extends Controller {
    /**
     * Fetches weather data based on workout form request
     * @param Request $request
     * @return json
     * 
     * @TODO: Refactor into a more generic class, based on the ServicesRepository
     */
    public function fetch(Request $request)
    {
        $strTime = $request->input('date') . 'T' . $request->input('time');
        $oTs = new Carbon($strTime, Config::get('app.timezone'));
        
        $client = $this->_getClient();
        $url = 'forecast/' . $this->_getKey() . '/' . 
            $request->input('lat') . ',' .$request->input('lon') .
            ',' . $oTs->getTimestamp() .
            '?units=auto&exclude=hourly,daily';
        $res = $client->request('GET', $url);
        if($res->getStatusCode() == 200) {
            return $res->getBody()->getContents();
        } else {
            Log::error($res->getStatusCode(). ' - ' . $res->getMessage());
        }      
    }
    
    
    /**
     * Fire up a Guzzle client.
     * 
     * @return a Guzzle Client Object
     */
    protected function _getClient()
    {
        return new Client(['base_uri' => 'https://api.darksky.net/',
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'json',
                ],
                
                'connect_timeout' => 10,
                'timeout' => 10
            ]);
    }

    /**
     * Get the proper application key
     * 
     * In this case, it is merely the developer key used from the environment file
     * 
     * @return type
     */
    protected function _getKey()
    {
        return env('DARKSKY_NET_API_KEY');
    }
}
