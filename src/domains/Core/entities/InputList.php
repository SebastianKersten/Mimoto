<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputList
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputList
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_LIST,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST,
            'visualName' => 'List',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_LIST],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_LIST.'--label',
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_LIST.'--description',
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
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
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_INPUT_LIST,
            'name' => CoreConfig::COREFORM_INPUT_LIST,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_LIST, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_LIST, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_LIST, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_LIST, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_LIST, 'validation')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_LIST);

        // setup
        CoreFormUtils::addField_title($form, 'List');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_LIST.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_LIST.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_LIST.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        $form->addValue('fields', self::getField_options());


        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form);

        // send
        return $form;
    }

    /**
     * Get field: type
     */
    private static function getField_options()
    {
        // create
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, CoreConfig::COREFORM_INPUT_LIST, 'options');

        // setup
        $field->setValue('label', 'Options');
        $field->setValue('description', 'Provide the options the user can pick from');

        // connect
        CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_INPUT_LIST, 'options');

        // MIMOTO_FORM_INPUT_LISTITEM_CREATE = has name and `form`
        // MIMOTO_FORM_INPUT_LISTITEM_SELECT = has name and `selection` (create or select)


        // COREFORM_FORM_INPUT_LISTITEM_CREATE
        // COREFORM_FORM_INPUT_LISTITEM_SELECT


        // LISTITEM has name, type, form, selection

        // select all from type="form"

        // 1. CREATE
        // 2. SELECT


        // configure
        $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $itemForm->setId(CoreConfig::MIMOTO_FORM_INPUTOPTION.'--options-item1');
        $itemForm->setValue('label', 'Label');

        // connect form
        $connectedForm = Mimoto::service('forms')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
        $itemForm->setValue('form', $connectedForm);
        $field->addValue('options', $itemForm);

        // send
        return $field;
    }

}
