<?php

// classpath
namespace Mimoto\library\data;

/**
 * MimotoDataPropertyInterface
 * @author Sebastian Kersten (@supertaboo)
 */
interface MimotoDataPropertyInterface
{
    
    /**
     * Start tracking changes
     */
    public function trackChanges();
    
    /**
     * Check if the value was changed
     * 
     * @return boolean True if value was changed
     */
    public function hasChanges();
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges();
    
}
