<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

use Mimoto\Core\forms\EntityForm;
use Mimoto\Core\forms\EntityPropertyForm;
use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;


/**
 * FormResponse
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormResponse
{


//$formResponse->newPublicKey
//
//
//$formResponse = (object) array(
//'status' => '?',
//'formName' => $sFormName,
//'errors' => []
//);




    public function setFormName()
    {
    }

    //public function setStatus()

    public function setNewPublicKey() {}



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
     * Add error
     */
    public function addError($sFieldName, $sMessage)
    {

    }

    //public function

}
