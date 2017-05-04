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
     * Init structure
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
                'jsEditor' => $customFormattingOption->getValue('jsEditor'),
                'attributes' => []
            );

            // store
            $aFormattingOptions[] = $formattingOption;
        }

        // 4. send
        return $aFormattingOptions;
    }

}
