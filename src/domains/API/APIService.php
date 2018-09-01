<?php

// classpath
namespace Mimoto\API;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Selection\Selection;


/**
 * APIService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class APIService
{

    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct() {}
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    public function render($eAPI, $aVars)
    {
        // 1. prepare
        $sServicesPath = Mimoto::service('config')->get('folders.projectroot').Mimoto::service('config')->get('folders.services');
        $eService = $eAPI->get('service');
        $eFunction = $eAPI->get('function');

        // 2. validate
        if (empty($sServicesPath) || empty($eService) || empty($sServiceName = $eService->get('name')) || empty($sServiceFile = $eService->get('file')) || empty(($eFunction)) || empty($sFunctionName = $eFunction->get('name')))
            return Mimoto::service('messages')->response('Service not configured', 500);

        // 3. verify
        if (!class_exists($sServiceName))
        {
            // a. prepare
            $sClassFile = $sServicesPath.$sServiceFile;

            // b. verify
            if (file_exists($sClassFile))
            {
                // I. load
                require_once($sClassFile);
            }
        }

        // 4. init class
        $service = new $sServiceName;

        // 5. verify
        if (!method_exists($service, $sFunctionName)) return Mimoto::service('messages')->response('Service function not available', 500);

        // 6. collect settings
        $settings = (object) array();
        $aAPISettings = $eAPI->get('settings');
        $nAPISettingCount = count($aAPISettings);
        for ($nAPISettingIndex = 0; $nAPISettingIndex < $nAPISettingCount; $nAPISettingIndex++)
        {
            // i. register
            $eAPISetting = $aAPISettings[$nAPISettingIndex];

            // ii. build and store
            $settings->{$eAPISetting->get('key')} = $eAPISetting->get('value');
        }

        // 7. apply variables (the & allows for direct editing of the value)
        foreach($settings as &$setting)
        {
            // a. replace enter or init
            if (!empty($setting)) $setting = preg_replace('/\\\n/', chr(13), $setting);

            // b. get variables
            if (preg_match_all('/({{.*?}})/', $setting, $aMatches))
            {
                // remove full match
                array_splice($aMatches, 0, 1);

                // I. replace
                $nSubmatchCount = count($aMatches);
                for ($nSubmatchIndex = 0; $nSubmatchIndex < $nSubmatchCount; $nSubmatchIndex++)
                {
                    // 1. register
                    $aSubmatches = $aMatches[$nSubmatchIndex];

                    $nVarCount = count($aSubmatches);
                    for ($nVarIndex = 0; $nVarIndex < $nVarCount; $nVarIndex++)
                    {
                        // a. register
                        $sMatch = $aSubmatches[$nVarIndex];

                        // b. isolate
                        $sPropertyName = trim(substr($sMatch, 2, strlen($sMatch) - 4));

                        // c. validate
                        if (!isset($aVars[$sPropertyName])) continue;

                        // d. inject
                        $setting = preg_replace('/'.$sMatch.'/', $aVars[$sPropertyName], $setting);
                    }
                }
            }
        }

        // 8. load instances
        $aInstances = [];
        $bIsSingle = true;
        $aSelections = $eAPI->get('selections');
        $nSelectionCount = count($aSelections);
        for ($nSelectionIndex = 0; $nSelectionIndex < $nSelectionCount; $nSelectionIndex++)
        {
            // a. register
            $eSelection = $aSelections[$nSelectionIndex];

            // b. init
            $selection = new Selection($eSelection);


            // todo - check if selection load single or multiple? (add as util to Selection class)

            // if multi selections -> array
            // if no instance (or var) -> array
            // if instance of idVar -> single
            // if property is set on selection and that property = entity -> single
            // if property is set on selection and that property = collection -> array

            // c. load
            $aInstances = array_merge($aInstances, Mimoto::service('data')->select($selection));
        }
        Mimoto::error('Number of instances = '.count($aInstances).' (this should be 1)');
        // 9. call and pass clone of settings (unserialize/serialize)
        $result = call_user_func([$service, $sFunctionName], ($bIsSingle) ? ((count($aInstances) > 0) ? $aInstances[0] : null) : $aInstances, $settings);

        // 10. respond
        return Mimoto::service('messages')->response($result, 200);
    }

}
