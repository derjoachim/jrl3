<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ForecastController extends Controller {
    /**
     * Fetches weather data based on workout form request
     * @param Request $request
     * @return json
     * @TODO: Refactor into Repository class.
     */
    public function fetch(Request $request) {
        $url = 'https://api.forecast.io/forecast/'.
            env('FORECAST_IO_API_KEY').'/'.$request->input('lat').','.$request->input('lon').
            ','.$request->input('date').'T'.$request->input('time').
            '?units=si&exclude=hourly,daily';
        return file_get_contents($url);
    }
}
