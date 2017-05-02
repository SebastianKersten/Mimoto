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
                CoreConfig::COREFORM_FORMATTINGOPTION
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--attributes',
                    // ---
                    'name' => 'attributes',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_FORMATTINGOPTIONATTRIBUTE]
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
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-bold'] = (object) array('name' => 'bold');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-italic'] = (object) array('name' => 'italic');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-underline'] = (object) array('name' => 'underline');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-strike'] = (object) array('name' => 'strike');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-script'] = (object) array('name' => 'script');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-code'] = (object) array('name' => 'code');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-link'] = (object) array('name' => 'link');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-color'] = (object) array('name' => 'color');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-background'] = (object) array('name' => 'background');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-font'] = (object) array('name' => 'font');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-size'] = (object) array('name' => 'size');

        // blocks
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-blockquote'] = (object) array('name' => 'blockquote');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-header'] = (object) array('name' => 'header');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-indent'] = (object) array('name' => 'indent');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-list'] = (object) array('name' => 'list');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-align'] = (object) array('name' => 'align');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-direction'] = (object) array('name' => 'direction');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-code-block'] = (object) array('name' => 'code-block');

        // embeds
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-formula'] = (object) array('name' => 'formula');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-image'] = (object) array('name' => 'image');
        $aData[CoreConfig::COREFORM_FORMATTINGOPTION.'-video'] = (object) array('name' => 'video');

        // send
        return $aData[$sItemId];
    }

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_FORMATTINGOPTION,
            'name' => CoreConfig::COREFORM_FORMATTINGOPTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORMATTINGOPTION, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORMATTINGOPTION, 'attributes')
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
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_FORMATTINGOPTION);

        // setup
        CoreFormUtils::addField_title($form, 'Property', '', "Formatting options can be used to add more functionality or styles to your texts. Think about a custom way of higlighting or functionality like comments.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_ENTITYPROPERTY.'--name',
            'Name', 'Formatting option name', 'The name should be unique'
        );
        self::setNameValidation($field);


        //$form->addValue('fields', self::getField_type());

        CoreFormUtils::addField_groupEnd($form);

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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The property name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation1');
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_ENTITYPROPERTY, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITYPROPERTY, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-image');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-video');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION.'|'.MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE.'|'.MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}
