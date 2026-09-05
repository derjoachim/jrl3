<?php

namespace App\Listeners;

use App\Events\LogDeleting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class LogDeleteListener
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
    public function handle(LogDeleting $event)
    {
        $kennyPath = $event->oLog->getParentDirectory();
        if( Storage::disk('local')->exists($kennyPath)) {
            Storage::deleteDirectory($kennyPath,true);
        } else {
            die("Kan om wat voor stomme reden dan ook " . $kennyPath . " niet verwijderen");
        }
    }
}
