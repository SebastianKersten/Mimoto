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
    public function silent($sTitle, $sMessage, $sDispatcher)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, $sDispatcher, 'silent');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function notify($sTitle, $sMessage, $sDispatcher)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, $sDispatcher, '');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function warn($sTitle, $sMessage, $sDispatcher)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, $sDispatcher, 'warning');
    }

    /**
     * Broadcast a regular notification to the developer
     */
    public function error($sTitle, $sMessage, $sDispatcher)
    {
        // forward
        $this->createNotification($sTitle, $sMessage, $sDispatcher, 'error');
    }

    /**
     * Create a notification
     * @param $sTitle
     * @param $sMessage
     * @param $sDispatcher
     * @param $sCategory
     */
    private function createNotification($sTitle, $sMessage, $sDispatcher, $sCategory)
    {
        // create
        $notification = $this->_MimotoEntityService->create(CoreConfig::MIMOTO_NOTIFICATION);

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
