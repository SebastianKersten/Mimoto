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
        // 1. get core
        // 2. get custom
        // 3. get type


        $aFormattingOptions = [];

        $aCustomFormattingOptions = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORMATTINGOPTION]);

        $nCustomFormattingOptionCount = count($aCustomFormattingOptions);
        for ($nCustomFormattingOptionIndex = 0; $nCustomFormattingOptionIndex < $nCustomFormattingOptionCount; $nCustomFormattingOptionIndex++)
        {
            // register
            $customFormattingOption = $aCustomFormattingOptions[$nCustomFormattingOptionIndex];

            // composer
            $formattingOption = (object) array(
                'name' => $customFormattingOption->getValue('name'),
                'type' => $customFormattingOption->getValue('type'),
                'attributes' => []
            );

            // store
            $aFormattingOptions[] = $formattingOption;
        }

        // send
        return $aFormattingOptions;
    }

}
