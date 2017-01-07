<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * MimotoAimlessUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessUtils
{
    
    public static function formatAimlessValue($sEntityType, $nId, $sPropertyName)
    {
        return $sEntityType.'.'.$nId.'.'.$sPropertyName;
    }
    
    public static function formatAimlessSubvalue($sEntityType, $nId, $sPropertyName)
    {
        return '['.$sEntityType.'.'.$nId.'.'.$sPropertyName.']';
    }
    
    public static function formatAimlessSubvalueWithoutId($sEntityType, $sPropertyName)
    {
        return '['.$sEntityType.'.'.$sPropertyName.']';
    }

    public static function getModule($sModuleName, $values = [])
    {
        // get module file
        $sModuleFile = Mimoto::service('aimless')->getComponentFile($sModuleName);

        // create
        $viewModel = new AimlessModuleViewModel();

        // init
        $aVars = $values;

        // compose
        $aVars['Aimless'] = $viewModel;

        // output
        return Mimoto::service('twig')->render($sModuleFile, $aVars);
    }
}
