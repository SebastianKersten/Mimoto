<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


/**
 * LayoutGroupEnd
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutGroupEnd
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
            'visualName' => 'Group end',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_LAYOUT_GROUPEND],
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
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_LAYOUT_GROUPEND,
            'name' => CoreConfig::COREFORM_LAYOUT_GROUPEND,
            'class' => get_class(),
            'inputFieldIds' => []
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_LAYOUT_GROUPEND, true);

        // setup
        CoreFormUtils::addField_title($form, 'Group end', 'This feature will be rewritten to form proper groups', "Add groups in order to make a form more pleasant and scannable for the content editor");

        // send
        return $form;
    }

}
