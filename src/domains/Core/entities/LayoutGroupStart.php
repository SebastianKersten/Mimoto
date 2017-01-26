<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * LayoutGroupStart
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutGroupStart
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
            'visualName' => 'Group start',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_LAYOUT_GROUPSTART],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'title',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                )
            ]
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
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_LAYOUT_GROUPSTART);

        // setup
        CoreFormUtils::addField_title($form, 'Group start', '', "Add groups in order to make a form more pleasant and scannable for the content editor. Use a 'group end' to close a previously started group of input fields.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title',
            'Title', 'Enter the group\'s label', ''
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }

}
