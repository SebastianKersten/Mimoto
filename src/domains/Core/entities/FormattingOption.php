<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * FormattingOption
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormattingOption
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            // ---
            'name' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            'extends' => null,
            'forms' => [
                CoreConfig::MIMOTO_FORMATTINGOPTION
            ],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--name',
                    // ---
                    'name' => 'name',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--type',
                    // ---
                    'name' => 'type',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--tagName',
                    // ---
                    'name' => 'tagName',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--jsOnAdd',
                    // ---
                    'name' => 'jsOnAdd',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--jsOnEdit',
                    // ---
                    'name' => 'jsOnEdit',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--toolbar',
                    // ---
                    'name' => 'toolbar',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--attributes',
                    // ---
                    'name' => 'attributes',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_FORMATTINGOPTION_ATTRIBUTE]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'value' => CoreConfig::DATA_VALUE_FALSE,
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN
                        )
                    ]
                )
            ]
        );
    }

    public static function getData($sItemId)
    {

        // #prototype - 'name' is the property to be set with setValue()


        // init
        $aData = [];

        // inline
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-bold'] = (object) array('name' => 'bold');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-italic'] = (object) array('name' => 'italic');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-underline'] = (object) array('name' => 'underline');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-strike'] = (object) array('name' => 'strike');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-script'] = (object) array('name' => 'script');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-code'] = (object) array('name' => 'code');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-link'] = (object) array('name' => 'link');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-color'] = (object) array('name' => 'color');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-background'] = (object) array('name' => 'background');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-font'] = (object) array('name' => 'font');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-size'] = (object) array('name' => 'size');

        // blocks
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-blockquote'] = (object) array('name' => 'blockquote');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-header'] = (object) array('name' => 'header', 'toolbar' => '{ "header": [1, 2, false] }');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-indent'] = (object) array('name' => 'indent');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-list'] = (object) array('name' => 'list');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-align'] = (object) array('name' => 'align');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-direction'] = (object) array('name' => 'direction');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-code-block'] = (object) array('name' => 'code-block');

        // embeds
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-formula'] = (object) array('name' => 'formula');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-image'] = (object) array('name' => 'image');
        $aData[CoreConfig::MIMOTO_FORMATTINGOPTION.'-video'] = (object) array('name' => 'video');

        // send
        return $aData[$sItemId];
    }

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            'name' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'tagName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'jsOnAdd'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'jsOnEdit'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORMATTINGOPTION, 'attributes')
            ]
        );
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
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_FORMATTINGOPTION);

        // setup
        CoreFormUtils::addField_title($form, 'Formatting', '', "Formatting options can be used to add more functionality or styles to your texts. Think about a custom way of higlighting or functionality like comments.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_FORMATTINGOPTION.'--name',
            'Name', 'Formatting option name', 'The name should be unique'
        );
        self::setNameValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'tagName', CoreConfig::MIMOTO_FORMATTINGOPTION.'--tagName',
            'Tag name', 'Enter the tag name', "For instance 'span', 'div', 'a', etc."
        );
        self::setTagNameValidation($field);


        $form->addValue('fields', self::getField_type());

        CoreFormUtils::addField_groupEnd($form);


        CoreFormUtils::addField_groupStart($form, 'Editor hooks', 'editorhooks');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'jsOnAdd', CoreConfig::MIMOTO_FORMATTINGOPTION.'--jsOnAdd',
            "Javascript function for 'add' event", 'Enter the javascript function name', "This function is called when this formatting option is added."
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'jsOnEdit', CoreConfig::MIMOTO_FORMATTINGOPTION.'--jsOnEdit',
            "Javascript function for 'edit' event", 'Enter the javascript function name', "This function is called when this formatting option is clicked."
        );

        CoreFormUtils::addField_groupEnd($form, 'editorhooks');

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------



    /**
     * Get field: name
     */
    private static function setNameValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--name_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);


//
//        // validation rule #3
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation3');
//        $validationRule->setValue('type', 'regex_custom');
//        $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
//        $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
//        $field->addValue('validation', $validationRule);
//
//        // validation rule #4
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation4');
//        $validationRule->setValue('type', 'api');
//        $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
//        $validationRule->setValue('errorMessage', 'The name needs to be unique');
//        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_FORMATTINGOPTION, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORMATTINGOPTION, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--type_value_options-inline');
        $option->setValue('label', 'Inline');
        $option->setValue('value', 'inline');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--type_value_options-block');
        $option->setValue('label', 'Block');
        $option->setValue('value', 'block');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--type_value_options-embeds');
        $option->setValue('label', 'Embeds');
        $option->setValue('value', 'embeds');
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^(inline|block|embeds)$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: tagName
     */
    private static function setTagNameValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_FORMATTINGOPTION.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The tag name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}
