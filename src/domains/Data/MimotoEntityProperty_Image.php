<?php

// classpath
namespace Mimoto\Data;


/**
 * MimotoEntityProperty_Image
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty_Image extends MimotoEntityProperty_Entity implements MimotoEntityPropertyInterface
{

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($propertyConfig, $xParentId, $xParentEntityTypeId)
    {
        // 1. forward
        parent::__construct($propertyConfig, $xParentId, $xParentEntityTypeId);

        // 2. init
        $this->_data = (object) array(
            'persistentEntity' => null,
            'currentEntity' => null
        );
    }

}
