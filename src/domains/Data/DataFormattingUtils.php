<?php

// classpath
namespace Mimoto\Data;


/**
 * DataFormattingUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DataFormattingUtils
{

    public static function lowerCameCase2Label($sLowerCamelCase)
    {
        // init
        $sLabel = '';

        // convert
        $sLowerCamelCase = preg_replace("/[-_]/", " ", $sLowerCamelCase);
        $sLowerCamelCase = preg_replace("/([A-Z])/", " \$1", $sLowerCamelCase);

        // split
        $aLabelParts = explode(' ', $sLowerCamelCase);

        $nLabelPartCount = count($aLabelParts);
        for ($nLabelPartIndex = 0; $nLabelPartIndex < $nLabelPartCount; $nLabelPartIndex++)
        {
            // register
            $sLabelPart = $aLabelParts[$nLabelPartIndex];

            // compose
            if ($nLabelPartIndex == 0)
            {
                $sLabel = strtoupper(substr($sLabelPart, 0, 1)).substr($sLabelPart, 1);
            }
            else
            {
                $sLabel .= ' '.strtolower($sLabelPart);
            }
        }

        // send
        return $sLabel;
    }

}
