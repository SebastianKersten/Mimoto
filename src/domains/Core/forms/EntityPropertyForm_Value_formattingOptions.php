<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


/**
 * EntityPropertyForm_Value_formattingOptions
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Value_formattingOptions
{

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS,
            'name' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS, 'type')
            ]
        );
    }

    /**
     * Get structure
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS);

        // setup
        CoreFormUtils::addField_title($form, 'Formatting options');
        CoreFormUtils::addField_groupStart($form);

        $form->addValue('fields', self::getField_formattingOptions());

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: formattingOptions
     */
    private static function getField_formattingOptions()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT, CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS, 'formattingOptions');
        $field->setValue('label', 'Allowed formatting options');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, 'formattingOptions');


        // -- custom options ---

        // load
        $aFormattingOptions = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORMATTINGOPTION]);

        $nFormattingOptionCount = count($aFormattingOptions);
        for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
        {
            // register
            $eFormattingOption = $aFormattingOptions[$nFormattingOptionIndex];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS.'-custom-'.$eFormattingOption->getId());
            $option->setValue('label', $eFormattingOption->getValue('name'));
            $option->setValue('value', $eFormattingOption->getEntityTypeName().'.'.$eFormattingOption->getId());
            $field->addValue('options', $option);
        }


        // --- core options ---


        $aCoreFormattingOptions = [

            // inline

            (object) array('label' => 'Bold', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-bold'),
            (object) array('label' => 'Italic', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-italic'),
            (object) array('label' => 'Underline', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-underline'),
            (object) array('label' => 'Strikethrough', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-strike'),
            (object) array('label' => 'Superscript/Subscript', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-script'),
            (object) array('label' => 'Inline Code', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-code'),
            (object) array('label' => 'Link', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-link'),

            (object) array('label' => 'Color', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-color'),
            (object) array('label' => 'Background Color', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-background'),
            (object) array('label' => 'Font', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-font'),
            (object) array('label' => 'Size', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-size'),

            // block

            (object) array('label' => 'Blockquote', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-blockquote'),
            (object) array('label' => 'Header', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header'),
//            (object) array('label' => 'Header 1', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header1'),
//            (object) array('label' => 'Header 2', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header2'),
//            (object) array('label' => 'Header 3', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header3'),
//            (object) array('label' => 'Header 4', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header4'),
//            (object) array('label' => 'Header 5', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header5'),
//            (object) array('label' => 'Header 6', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-header6'),
            (object) array('label' => 'Indent', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-indent'),
            // -1 | +1
            (object) array('label' => 'List', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-list'),
            // ordered | bullet
            (object) array('label' => 'Text Alignment', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-align'),
            (object) array('label' => 'Text Direction', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-direction'),
            (object) array('label' => 'Code Block', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-code-block'),

            // embeds

            (object) array('label' => 'Formula', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-formula'),
            (object) array('label' => 'Image', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-image'),
            (object) array('label' => 'Video', 'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'-video')
        ];


        // 1. convert core options to entities (hardcoded)


        $nFormattingOptionCount = count($aCoreFormattingOptions);
        for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
        {
            // register
            $formattingOption = $aCoreFormattingOptions[$nFormattingOptionIndex];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS.'-core-'.$nFormattingOptionIndex);
            $option->setValue('label', $formattingOption->label);
            $option->setValue('value', CoreConfig::MIMOTO_FORMATTINGOPTION.'.'.$formattingOption->id);
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

}
