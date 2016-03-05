<?php

// classpath
namespace Momkai\Event;


/**
 * EventService
 *
 * @author Sebastian Kersten
 */
class EventService
{
    
    // services
    private $_dispatcher;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($dispatcher)
    {
        // register
        $this->_dispatcher = $dispatcher;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Send update
     * @param string $sEvent
     * @param event $event
     */
    public function sendUpdate($sEvent, $event)
    {
        $this->_dispatcher->dispatch($sEvent, $event); // type in event, MimotoEvent
    }
    
     /**
     * Send request
     * @param string $sEvent
     * @param event $event
     */
    public function sendRequest($sEvent, $event)
    {
        $this->_dispatcher->dispatch('REQUEST', $event);
    }
    
}
