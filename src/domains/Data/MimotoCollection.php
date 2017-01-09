<?php

// classpath
namespace Mimoto\Data;


/**
 * MimotoCollection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoCollection extends \ArrayObject
{
    
    private $_criteria;
    
    
    public function setCriteria($criteria)
    {
        $this->_criteria = $criteria;
    }
    
    public function getCriteria()
    {
        return $this->_criteria;
    }

    public function isEmpty()
    {
        return count($this) == 0;
    }
}
