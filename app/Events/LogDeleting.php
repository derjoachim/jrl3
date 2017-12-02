<?php
namespace App\Events;


use App\Models\Log as LogModel;

class LogDeleting 
{
    public $oLog;
    
    public function __construct(LogModel $oLog)
    {
        $this->oLog = $oLog;
    }
    
    
}
