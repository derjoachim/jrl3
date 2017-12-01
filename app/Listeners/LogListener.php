<?php

namespace App\Listeners;

use App\Events\LogSaved;
use App\Models\Route;
use App\Models\Workout;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;
use Storage;

class LogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LogSaved  $event
     * @return void
     */
    public function handle(LogSaved $event)
    {
        $oLog = $event->oLog;
        $iUserId = $oLog->user_id;
        if( empty($oLog->path)) {
            $strPath = $oLog->getOrSetStoragePath();
            $strFileName = 'log_' . $oLog->id . '.pdf';
            $oLog->path = $strPath . DIRECTORY_SEPARATOR . $strFileName;
            $oLog->save();
        }
        $Data = Array();
        $Data['log'] = $oLog;
        $workouts = Workout::whereUserId($iUserId)->whereBetween('date', [$oLog->start_date, $oLog->end_date])->orderBy('date')->get();
        $routes = Route::whereIn('id', $workouts->pluck('route_id'))->get();
        $Data['workouts'] = $workouts; 
        $Data['routes'] = $routes;
        $Data['user'] = User::find($iUserId);
        $html = view('logs.pdf.logfile', $Data);
        PDF::loadHTML($html)->setOption('toc', true)
                ->setPaper('a4')
                ->setOption('footer-center', '[page] / [topage]')
                ->save(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $oLog->path, true);
    }
}
