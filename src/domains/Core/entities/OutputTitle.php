<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * OutputTitle
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputTitle
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            'visualName' => 'Title',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_OUTPUT_TITLE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--title',
                    // ---
                    'name' => 'title',
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
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--subtitle',
                    // ---
                    'name' => 'subtitle',
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
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--description',
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
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
            'id' => CoreConfig::COREFORM_OUTPUT_TITLE,
            'name' => CoreConfig::COREFORM_OUTPUT_TITLE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_OUTPUT_TITLE, 'title'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_OUTPUT_TITLE, 'subtitle'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_OUTPUT_TITLE, 'description')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_OUTPUT_TITLE);

        // setup
        CoreFormUtils::addField_title($form, 'Title');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'title', CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--title',
            'Title',
            'Enter the title',
            ''
        );
        self::setTitleValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'subtitle', CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--subtitle',
            'Subtitle',
            'Enter a subtitle',
            ''
        );

        $field = CoreFormUtils::addField_textblock
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--description',
            'Description',
            'Enter a description',
            'Describe to the user what the form is about'
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set title validation
     */
    private static function setTitleValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--title_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The title can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}
