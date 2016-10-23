<?php

// classpath
namespace Mimoto\Log;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * MimotoLogService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoLogService
{

    // services
    private $_MimotoEntityService;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($MimotoEntityService)
    {
        // register
        $this->_MimotoEntityService = $MimotoEntityService;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Broadcast a silent notification to the developer
     */
    public function silent($sTitle, $sMessage)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, debug_backtrace()[1].'', 'silent');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function notify($sTitle, $sMessage)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, debug_backtrace()[1], '');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function warn($sTitle, $sMessage)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, debug_backtrace()[1], 'warning');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function error($sTitle, $sMessage, $bOutputErrorToUser = false)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, debug_backtrace()[1], 'error');

        // outut
        if ($bOutputErrorToUser) error($sTitle." - ".$sMessage);
    }

    /**
     * Create a notification
     * @param $sTitle
     * @param $sMessage
     * @param $sDispatcher
     * @param $sCategory
     */
    private function createNotification($sTitle, $sMessage, $debugBacktrace, $sCategory)
    {
        // create
        $notification = $this->_MimotoEntityService->create(CoreConfig::MIMOTO_NOTIFICATION);

        // prepare
        $sDispatcher = $debugBacktrace['class'].'::'.$debugBacktrace['function'];
        if (isset($debugBacktrace['line'])) { $sDispatcher .= ' (called from line #'.$debugBacktrace['line'].')'; }

        // setup
        $notification->setValue('title', $sTitle);
        $notification->setValue('message', $sMessage);
        $notification->setValue('dispatcher', $sDispatcher);
        $notification->setValue('category', $sCategory);
        $notification->setValue('state', 'open');

        // store
        $this->_MimotoEntityService->store($notification);
    }

}
