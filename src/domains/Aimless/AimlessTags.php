<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\EntityService;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Log\LogService;


/**
 * AimlessTags
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessTags
{


    var $_entity = null;
    var $_sPropertyName = null;
    var $_editOptions = null;


    const ATTRIBUTE_PREFIX = 'data-mimoto-';


    public function __construct($entity)
    {
        // register
        $this->_entity = $entity;
    }


    public function setEdit($sPropertyName, $editOptions)
    {
        // register
        $this->_sPropertyName = $sPropertyName;
        $this->_editOptions = $editOptions;
    }


    public function render()
    {
        // init
        $sTags = '';


        if (!empty($this->_sPropertyName))
        {
            // convert
            $sJsonOptions = (!empty($this->_editOptions)) ? json_encode($this->_editOptions) : '';

            // compose
            $sTags .= self::ATTRIBUTE_PREFIX.'editable="'.$this->_entity->getEntityTypeName().'.'.$this->_entity->getId().'.'.$this->_sPropertyName.'" '.self::ATTRIBUTE_PREFIX.'editable-options=\''.$sJsonOptions.'\'';
        }


        // output
        return $sTags;
    }
}
