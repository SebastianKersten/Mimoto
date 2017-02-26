<?php

// classpath
namespace Mimoto\Log;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;


/**
 * LogService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LogService
{

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {

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
        $this->createNotification($sTitle, $sMessage, debug_backtrace()[1], 'silent');
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
        $eNotification = Mimoto::service('data')->create(CoreConfig::MIMOTO_NOTIFICATION);

        // prepare
        $sDispatcher = $debugBacktrace['class'].'::'.$debugBacktrace['function'];
        if (isset($debugBacktrace['line'])) { $sDispatcher .= ' (called from line #'.$debugBacktrace['line'].')'; }

        // setup
        $eNotification->setValue('title', $sTitle);
        $eNotification->setValue('message', $sMessage);
        $eNotification->setValue('dispatcher', $sDispatcher);
        $eNotification->setValue('category', $sCategory);
        $eNotification->setValue('state', 'open');

        // store
        Mimoto::service('data')->store($eNotification);

        // get
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT);

        // connect
        $eRoot->addValue('notifications', $eNotification);

        // store
        Mimoto::service('data')->store($eRoot);
    }

}
