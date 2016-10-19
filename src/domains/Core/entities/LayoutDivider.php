<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * LayoutDivider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutDivider
{

    public static function getStructure()
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

    public static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }

}
