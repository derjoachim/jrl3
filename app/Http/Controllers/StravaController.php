<?php namespace Jrl3\Http\Controllers;
use Auth;
use Config;
use Carbon\Carbon;
use DB;
use Input;
use Jrl3\Http\Requests;
use Jrl3\Http\Controllers\Controller;
use Jrl3\Repositories\StravaServiceRepository;
use Illuminate\Http\Request;
use Jrl3\Route;
use Jrl3\Workout;

class StravaController extends Controller {
    
    private $fs;
    
    public function __construct(StravaServiceRepository $stravaRepository) 
    {
        $this->fs = $stravaRepository;
    }
    
    public function latest()
    {
        $latest_strava_workouts = $this->fs->latest();
        $body = json_decode($latest_strava_workouts->body);//->toJson();
        $workouts = array();
        $tz = Config::get('app.timezone');

        foreach($body as $w) {
            $arrW = array();
            $arrW['id'] = $w->id;
            $ts = Carbon::parse($w->start_date,'UTC');
            $ts->setTimezone($tz);
            $arrW['date'] = $ts->format('d-m-Y');
            $arrW['name'] = $w->name;
            $arrW['distance'] = round($w->distance / 1000, 2);
            $arrW['time'] = $this->getTime($w->elapsed_time);
            $workouts[] = $arrW;
        }
        return view('strava.index',compact('workouts'));
    }
    
    public function import()
    {
        $id = Input::get('id');
        $activity = $this->fs->import($id);

        $body = json_decode($activity->body);
 
        $ts = Carbon::parse($body->start_date,'UTC');
        $ts->setTimezone(Config::get('app.timezone'));
        $arrFld = array(
            'name' => $body->name,
            'date' => $ts->format('Y-m-d'),
            'slug' => $ts->format('Y-m-d').'-'.'strava-import', 
            'user_id' => Auth::user()->id,
            'distance' => round(($body->distance / 1000) ,2),
            'start_time' => $ts->format('H:i:s'),
            'time_in_seconds' => $body->moving_time,
            'lat_start' => $body->start_latlng[0],
            'lon_start' => $body->start_latlng[1],
            'lat_finish' => $body->end_latlng[0],
            'lon_finish' => $body->end_latlng[1],
            'description' => $body->description,
            'created_at' => Carbon::now(),
        );
 
        $polyline = $body->map->polyline;
        //dd($this->decodePolylineToArray($polyline));
        $workout_id = DB::table('workouts')->insertGetId($arrFld);

        // Parse polyline into coordinates, create waypoint records.
        $arrPolylinePoints = $this->decodePolylineToArray($body->map->polyline);
        $arrWps = array();
        foreach ( $arrPolylinePoints as $wp ) {
            $arrWps[] = array(
                'workout_id' => $workout_id,
                'lon' => $wp[1],
                'lat' => $wp[0]
            );
        }
        DB::table('waypoints')->insert($arrWps);
     
        // mark this workout as 'imported' from Strava.
        $arSrv = array(
            'workout_id' => $workout_id,
            'fitness_service_id' => 1,
            'fitness_service_remote_identifier' => Input::get('id'),
            'timestamp' => Carbon::now()
        );
        DB::table('workouts_fitness_services')->insert($arSrv);
        
        // Redirect to the edit screen
        $workout = Workout::find($workout_id);
        $routes = array('' => '--- Geen route ---') + Route::lists('name','id')->all();
        $t = $workout->getTime();
        $date = $workout->date->format('Y-m-d');
        $mood = 3;
        $health = 3;
        return view('workouts.edit', compact('workout','routes','mood','health','t','date'));
    }
    
    /**
     * Source: http://unitstep.net/blog/2008/08/02/decoding-google-maps-encoded-polylines-using-php/
     * 
     * Decodes a polyline that was encoded using the Google Maps method.
     *
     * The encoding algorithm is detailed here:
     * http://code.google.com/apis/maps/documentation/polylinealgorithm.html
     *
     * This function is based off of Mark McClure's JavaScript polyline decoder
     * (http://facstaff.unca.edu/mcmcclur/GoogleMaps/EncodePolyline/decode.js)
     * which was in turn based off Google's own implementation.
     *
     * This function assumes a validly encoded polyline.  The behaviour of this
     * function is not specified when an invalid expression is supplied.
     *
     * @param String $encoded the encoded polyline.
     * @return Array an Nx2 array with the first element of each entry containing
     *  the latitude and the second containing the longitude of the
     *  corresponding point.
     */
    private function decodePolylineToArray($encoded)
    {
      $length = strlen($encoded);
      $index = 0;
      $points = array();
      $lat = 0;
      $lng = 0;

      while ($index < $length)
      {
        // Temporary variable to hold each ASCII byte.
        $b = 0;

        // The encoded polyline consists of a latitude value followed by a
        // longitude value.  They should always come in pairs.  Read the
        // latitude value first.
        $shift = 0;
        $result = 0;
        do
        {
          // The `ord(substr($encoded, $index++))` statement returns the ASCII
          //  code for the character at $index.  Subtract 63 to get the original
          // value. (63 was added to ensure proper ASCII characters are displayed
          // in the encoded polyline string, which is `human` readable)
          $b = ord(substr($encoded, $index++)) - 63;

          // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
          // Then left shift the bits by the required amount, which increases
          // by 5 bits each time.
          // OR the value into $results, which sums up the individual 5-bit chunks
          // into the original value.  Since the 5-bit chunks were reversed in
          // order during encoding, reading them in this way ensures proper
          // summation.
          $result |= ($b & 0x1f) << $shift;
          $shift += 5;
        }
        // Continue while the read byte is >= 0x20 since the last `chunk`
        // was not OR'd with 0x20 during the conversion process. (Signals the end)
        while ($b >= 0x20);

        // Check if negative, and convert. (All negative values have the last bit
        // set)
        $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));

        // Compute actual latitude since value is offset from previous value.
        $lat += $dlat;

        // The next values will correspond to the longitude for this point.
        $shift = 0;
        $result = 0;
        do
        {
          $b = ord(substr($encoded, $index++)) - 63;
          $result |= ($b & 0x1f) << $shift;
          $shift += 5;
        }
        while ($b >= 0x20);

        $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        $lng += $dlng;

        // The actual latitude and longitude values were multiplied by
        // 1e5 before encoding so that they could be converted to a 32-bit
        // integer representation. (With a decimal accuracy of 5 places)
        // Convert back to original values.
        $points[] = array($lat * 1e-5, $lng * 1e-5);
      }

      return $points;
    }
    
    private function getTime($secs)
    {
        $t = ($secs > 3600 ? 'H:' : '') . 'i:s';
        return gmdate($t, $secs);
    }
}
