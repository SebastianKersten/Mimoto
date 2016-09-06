<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * CoreConfig__Mimoto_Form_Layout_Divider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig__Mimoto_Form_Layout_Divider
{

    static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
            'extends' => null,
            'properties' => []
        );
    }

    static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }

}