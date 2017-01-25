<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityPropertyForm_Collection_allowDuplicates
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Collection_allowDuplicates
{

    /**
     * Get structure
     */
    public static function getStructure()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES);


        // setup
        CoreFormUtils::addField_title($form, 'Configure');
        CoreFormUtils::addField_groupStart($form);

        CoreFormUtils::addField_checkbox
        (
            $form, 'value', CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value',
            'Configuration',
            'Allow duplicates'
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }

}
