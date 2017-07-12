<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * RoutePath
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class RoutePath
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ROUTE_PATH,
            // ---
            'name' => CoreConfig::MIMOTO_ROUTE_PATH,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ROUTE_PATH],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ROUTE_PATH.'--elements',
                    // ---
                    'name' => 'elements',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                )
            ]
        );
    }

    public static function getData()
    {

    }



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ROUTE_PATH,
            'name' => CoreConfig::MIMOTO_ROUTE_PATH,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ROUTE_PATH, 'elements')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {

    }

}
