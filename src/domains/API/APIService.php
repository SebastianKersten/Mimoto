<?php

// classpath
namespace Mimoto\API;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Selection\Selection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * APIService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class APIService
{

    const ERROR_SERVICE_NOT_AVAILABLE = 'Service not configured';
    const ERROR_SERVICE_FUNCTION_NOT_CONFIGURED = 'Service function not available';
    const ERROR_NO_RESULT = 'No result';

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
            return (!$eAPI->get('outputRawResponse')) ? Mimoto::service('messages')->response(self::ERROR_SERVICE_NOT_AVAILABLE, 500) : new Response(self::ERROR_SERVICE_NOT_AVAILABLE, 500);

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
        if (!method_exists($service, $sFunctionName)) return (!$eAPI->get('outputRawResponse')) ? Mimoto::service('messages')->response(self::ERROR_SERVICE_FUNCTION_NOT_CONFIGURED, 500) : new Response(self::ERROR_SERVICE_FUNCTION_NOT_CONFIGURED, 500);

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
        $bWillReturnSingleResult = true;
        $aSelections = $eAPI->get('selections');
        $nSelectionCount = count($aSelections);
        for ($nSelectionIndex = 0; $nSelectionIndex < $nSelectionCount; $nSelectionIndex++)
        {
            // a. register
            $eSelection = $aSelections[$nSelectionIndex];

            // b. init
            $selection = new Selection($eSelection);

            // c. apply
            foreach($aVars as $sVarName => $value) $selection->applyVar($sVarName, $value);

            // d. verify or toggle
            if ($bWillReturnSingleResult && !$selection->willReturnSingleResult()) $bWillReturnSingleResult = false;

            // e. load
            $aInstances = array_merge($aInstances, Mimoto::service('data')->select($selection));
        }

        // 9. verify
        if (count($aSelections) > 0 && $bWillReturnSingleResult && count($aInstances) == 0) return (!$eAPI->get('outputRawResponse')) ? Mimoto::service('messages')->response(self::ERROR_NO_RESULT, 404) : new Response(self::ERROR_NO_RESULT, 404);

        // 10. call and pass clone of settings (unserialize/serialize)
        $result = call_user_func([$service, $sFunctionName], ($bWillReturnSingleResult) ? ((count($aInstances) > 0) ? $aInstances[0] : null) : $aInstances, $settings);

        // 11. respond
        return (!$eAPI->get('outputRawResponse')) ? Mimoto::service('messages')->response($result, 200) : new JsonResponse($result, 200);
    }

}
