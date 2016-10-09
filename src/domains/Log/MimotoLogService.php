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
     * Notify developer
     */
    public function notify($sMessage)
    {
        // create
        $notification = $this->_MimotoEntityService->create('notification');

        // setup
        $notification->setValue('message', $sMessage);

        // store
        $this->_MimotoEntityService->store($notification);
    }

}
