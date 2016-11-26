<?php

// classpath
namespace Mimoto\Data;


/**
 * Interface for MimotoEntityProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
interface MimotoEntityPropertyInterface
{
    // constructor
    public function __construct($propertyConfig, $xParentId, $xParentEntityTypeId);

    // data
    public function getValue($bGetConnectionInfo = false, $sSubpropertySelector = null);
    public function setValue($value, $sSubpropertySelector = null);
    public function addValue($value, $sSubpropertySelector = null, $sEntityType = null);
    public function removeValue($value, $sSubpropertySelector = null, $sEntityType = null);

    // change management
    public function getChanges();
    public function acceptChanges();
}
