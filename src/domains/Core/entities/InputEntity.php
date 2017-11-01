<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputEntity
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputEntity
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_ENTITY,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_ENTITY,
            'visualName' => 'Entity',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_ENTITY],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_ENTITY.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_ENTITY.'--description',
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
            'id' => CoreConfig::COREFORM_INPUT_ENTITY,
            'name' => CoreConfig::COREFORM_INPUT_ENTITY,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_ENTITY, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_ENTITY, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_ENTITY, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_ENTITY, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_ENTITY, 'validation')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm($eInputList = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_ENTITY, true);

        // setup
        CoreFormUtils::addField_title($form, 'Entity');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_ENTITY.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_ENTITY.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_ENTITY.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        $form->addValue('fields', self::getField_options());


        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputList);

        // send
        return $form;
    }

    /**
     * Get field: type
     */
    private static function getField_options()
    {
        // create
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, CoreConfig::COREFORM_INPUT_ENTITY, 'options');

        // setup
        $field->setValue('label', 'Options');
        $field->setValue('description', 'Provide the options the user can pick from');

        // connect
        CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_INPUT_ENTITY, 'options');

        // MIMOTO_FORM_INPUT_ENTITYITEM_CREATE = has name and `form`
        // MIMOTO_FORM_INPUT_ENTITYITEM_SELECT = has name and `selection` (create or select)


        // COREFORM_FORM_INPUT_LISTITEM_CREATE
        // COREFORM_FORM_INPUT_LISTITEM_SELECT


        // LISTITEM has name, type, form, selection

        // select all from type="form"

        // 1. CREATE
        // 2. SELECT


        // configure
        $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $itemForm->setId(CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--options-item1');
        $itemForm->setValue('label', 'Label');

        // connect form
        $connectedForm = Mimoto::service('input')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
        $itemForm->setValue('form', $connectedForm);
        $field->addValue('options', $itemForm);

        // send
        return $field;
    }

}
