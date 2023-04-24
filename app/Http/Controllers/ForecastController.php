<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\{Log, Config};
use Illuminate\Http\Request;

final class ForecastController extends Controller
{
    /**
     * Fetches weather data based on workout form request
     * @param Request $request
     * @return json
     *
     * https://api.openweathermap.org/data/3.0/onecall/timemachine?lat={lat}&lon={lon}&dt={time}&appid={API key}
     * @TODO: Refactor into a more generic class, based on the ServicesRepository
     */
    public function fetch(Request $request)
    {
        $strTime = $request->input('date') . 'T' . $request->input('time');
        $oTs = new Carbon($strTime, Config::get('app.timezone'));

        $client = $this->_getClient();
        $url = 'data/3.0/onecall/timemachine?lat=' .
            $request->input('lat') .
            '&lon=' . $request->input('lon') .
            '&dt=' . $oTs->getTimestamp() .
            '&appid=' . $this->_getKey() .
            '&units=metric';
        $res = $client->request('GET', $url);
        if ($res->getStatusCode() === 200) {
            return $res->getBody()->getContents();
        } else {
            Log::alert("Unexpected response from openweather.org:" . $res->getStatusCode() . ' ' . $res->getReasonPhrase());
        }
    }


    /**
     * Fire up a Guzzle client.
     *
     * @return a Guzzle Client Object
     */
    protected function _getClient() :Client
    {
        return new Client(['base_uri' => 'https://api.openweathermap.org/',
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
    private function _getKey()
    {
        return Config::get('services.openweather_org.key');
    }
}
