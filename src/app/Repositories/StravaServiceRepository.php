<?php namespace App\Repositories;

use DB;
use Illuminate\Http\Request;
use Strava;
use App\Models\FitnessService;
use Cache;
use Carbon\Carbon;

final class StravaServiceRepository extends ServicesRepository
{
    public function __construct($name = 'strava')
    {
        parent::__construct($name);
    }
    
    
    /**
     * Authenticate Strava user
     *
     * @return mixed
     */
    public function authenticate()
    {
        return Strava::authenticate();
    }
    
    
    /**
     * Get an oauth token from Strava
     *
     * @param  Request  $request
     */
    public function getToken(Request $request)
    {
        $code = $request->code;
        $token = Strava::token($code);
        $oSrv = Cache::remember('fitness_service_'.$this->service_id, 120, function() use($token) {
            FitnessService::where('id', $this->service_id)->update([
                'access_token' => $token->access_token,
                'refresh_token' => $token->refresh_token,
                'expires_at' => $token->expires_at
            ]);
            return FitnessService::find($this->service_id);
        });
    }
    
    
    private function _refreshToken()
    {
        $oSrv = Cache::remember('fitness_service_'.$this->service_id, 120, function() {
            return FitnessService::find($this->service_id);
        });
        if($oSrv->expires_at < Carbon::now()->timestamp) {
            $token = Strava::refreshToken($oSrv->refresh_token);
            Cache::forget('fitness_service_'.$this->service_id);
            $oSrv->update(['access_token' => $token->access_token, 'refresh_token' => $token->refresh_token, 'expires_at' => $token->expires_at]);
        }
        return $oSrv->access_token;
    }
    
    /**
     * Get the latest Strava workouts
     *
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function latest()
    {
        $token = $this->_refreshToken();
        return Strava::activities($token);
    }
    
    
    /**
     * Try to import a Strava workout by ID
     *
     * @param  int  $id
     * @return mixed
     */
    public function import(int $id)
    {
        $token = $this->_refreshToken();
        return Strava::activity($token, $id);
    }
    
    
    public function getKey()
    {
        return $this->api_key;
    }
    
    
    /**
     * Try to match a strava workout to a JRL workout
     *
     * @param  int  $id
     * @return int|null
     */
    public function getWorkoutId(int $id)
    {
        $wfs = DB::table('workouts_fitness_services')
            ->where('fitness_service_id', '=', $this->service_id)
            ->where('fitness_service_remote_identifier', '=', $id)->first();
        if ($wfs) {
            return $wfs->workout_id;
        }
        return null;
    }
}