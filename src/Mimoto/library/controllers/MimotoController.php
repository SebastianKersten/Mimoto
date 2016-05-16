<?php

// classpath
namespace Mimoto\library\controllers;

// Mimoto classes
use Mimoto\library\thirdparty\


/**
 * MimotoController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoController
{
    
    protected $Mimoto;
    
    
    public function __construct() {
        
        $this->Mimoto = new MimotoPublicAPI();
                
    }
    
}
