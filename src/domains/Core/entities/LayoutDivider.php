<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


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
            'visualName' => 'Divider',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_LAYOUT_DIVIDER],
            'properties' => []
        );
    }

    public static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_LAYOUT_DIVIDER);

        // setup
        CoreFormUtils::addField_title($form, 'Divider', '', "Add dividers to make a form more pleasant and scannable for the content editor");

        // send
        return $form;
    }

}
