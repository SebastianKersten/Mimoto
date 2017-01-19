<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


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
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_DIVIDER);

        // setup
        $form->addValue('fields', self::getField_title('Divider'));

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Init structure
     */
    private static function initForm($sFormName)
    {
        // init
        $form = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId($sFormName);
        $form->setValue('name', $sFormName);
        $form->setValue('realtimeCollaborationMode', false);

        // send
        return $form;
    }

    /**
     * Get field: title
     */
    private static function getField_title($sTitle)
    {
        // create and setup
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_LAYOUT_DIVIDER.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "Add dividers to make a form more pleasant and scannable for the content editor");

        // send
        return $field;
    }


}
