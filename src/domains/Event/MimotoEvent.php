<?php

// classpath
namespace Mimoto\Event;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


class MimotoEvent extends Event
{
    
    /**
     * The entity
     * 
     * @var entity 
     */
    private $_entity;
    
    /**
     * The event type
     * 
     * @var string 
     */
    private $_sEvent;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constants --------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * The CREATED event
     * 
     * @const string
     */
    const CREATED = 'created';
    
    /**
     * The UPDATED event
     * 
     * @const string
     */
    const UPDATED = 'updated';

    /**
     * The DELETED event
     *
     * @const string
     */
    const DELETED = 'deleted';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the entity
     * 
     * @return entity
     */
    public function getEntity() { return $this->_entity; }
    
    /**
     * Get event type
     * 
     * @return string
     */
    public function getType() { return $this->_entity->getEntityTypeName().'.'.$this->_sEvent; }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param type $entity
     * @param string $sEvent
     */
    public function __construct($entity, $sEvent)
    {
        // register
        $this->_entity = $entity;
        $this->_sEvent = $sEvent;
    }
    
}
