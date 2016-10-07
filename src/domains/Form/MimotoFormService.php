<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * MimotoFormService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoFormService
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
     * Get form by its name
     */
    public function getFormByName($sFormName)
    {
        // 1. load form from database
        $aResults = $this->_MimotoEntityService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $sFormName]]);

        // 2. validate if form exists
        if (!isset($aResults[0])) error("Aimless says: Form with name '".$sFormName."' not found in database");
        // #todo - silent fail?
        
        // send
        return $aResults[0];
    }
    
}
