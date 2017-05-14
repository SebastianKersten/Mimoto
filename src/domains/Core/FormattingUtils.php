<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * FormattingUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormattingUtils
{
    /**
     * Get custom formatting options
     */
    public static function getCustomFormattingOptions()
    {
        // 1. init
        $aFormattingOptions = [];

        // 2. load
        $aCustomFormattingOptions = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORMATTINGOPTION]);

        // 3. parse
        $nCustomFormattingOptionCount = count($aCustomFormattingOptions);
        for ($nCustomFormattingOptionIndex = 0; $nCustomFormattingOptionIndex < $nCustomFormattingOptionCount; $nCustomFormattingOptionIndex++)
        {
            // register
            $customFormattingOption = $aCustomFormattingOptions[$nCustomFormattingOptionIndex];

            // composer
            $formattingOption = (object) array(
                'name' => $customFormattingOption->getValue('name'),
                'type' => $customFormattingOption->getValue('type'),
                'tagName' => $customFormattingOption->getValue('tagName'),
                'jsOnAdd' => $customFormattingOption->getValue('jsOnAdd'),
                'jsOnEdit' => $customFormattingOption->getValue('jsOnEdit'),
                'attributes' => []
            );

            // store
            $aFormattingOptions[] = $formattingOption;
        }

        // 4. send
        return $aFormattingOptions;
    }

    /**
     * Init formatting options
     */
    public static function initFormattingOptions()
    {
        return (object) array(
            'toolbar' => [],
            'formats' => []
        );
    }

    /**
     * Compose formatting options
     */
    public static function composeFormattingOptions($eEntityPropertySettingWithFormattingOptions, $formattingOptions = null)
    {
        // verify or init
        if (empty($formattingOptions)) $formattingOptions = FormattingUtils::initFormattingOptions();


        // read
        $aRegisteredFormattingOptions = $eEntityPropertySettingWithFormattingOptions->getValue('formattingOptions');

        // compose
        $nFormattingOptionCount = count($aRegisteredFormattingOptions);
        for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
        {
            // register
            $registeredFormattingOption = $aRegisteredFormattingOptions[$nFormattingOptionIndex];


            if (!empty($registeredFormattingOption->getValue('toolbar')))
            {
                $formattingOptions->toolbar[] = json_decode($registeredFormattingOption->getValue('toolbar'));
            }
            else
            {
                $formattingOptions->toolbar[] = $registeredFormattingOption->getValue('name');;
            }

            // compose
            $formattingOptions->formats[] = $registeredFormattingOption->getValue('name');
        }


        // send
        return $formattingOptions;
    }

}
