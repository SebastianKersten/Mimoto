<?php

// classpath
namespace Mimoto\Action;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * ActionService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionService
{

    // config data
    private $_aActionConfigs = [];



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {
        // toggle between cache or database
        if ( Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.actionconfigs'))
        {
            // load
            $this->_aActionConfigs = Mimoto::service('cache')->getValue('mimoto.core.actionconfigs');
        }
        else
        {
            // load
            $this->_aActionConfigs = CoreConfig::getCoreActions();
            $this->_aActionConfigs = array_merge($this->_aActionConfigs, $this->loadProjectActionConfigs());

            // cache
            if (Mimoto::service('cache')->isEnabled())
            {
                Mimoto::service('cache')->setValue('mimoto.core.actionconfigs', $this->_aActionConfigs);
            }
        }
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------


    //public function getActionsByEvent($sEvent)
    public function getAllActions()
    {
        return $this->_aActionConfigs;
    }


    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load project forms
     */
    private function loadProjectActionConfigs()
    {
        // 1. init
        $aActionConfigs = [];

        // 2. load
        $aActions = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_ACTION]);

        // 3. build and store
        $nActionCount = count($aActions);
        for ($nActionIndex = 0; $nActionIndex < $nActionCount; $nActionIndex++)
        {
            // a. register
            $eAction = $aActions[$nActionIndex];

            // b. build
            $actionConfig = (object) array(
                'owner' => (!empty($eAction->get('service.owner'))) ? $eAction->get('service.owner') : 'project',
                'trigger' => [$eAction->get('entity.name').'.'.$eAction->get('event')],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => $eAction->get('service.name'),
                    'file' => $eAction->get('service.file')
                ),
                'function' => $eAction->get('function.name'),
                'type' => 'sync',
                'settings' => (object) array()
            );

            // c. add conditionals
            $aActionConditionals = $eAction->get('conditionals');
            $nActionConditionalCount = count($aActionConditionals);
            for ($nActionConditionalIndex = 0; $nActionConditionalIndex < $nActionConditionalCount; $nActionConditionalIndex++)
            {
                // i. register
                $eActionConditional = $aActionConditionals[$nActionConditionalIndex];

                // ii. build and store
                $actionConfig->conditionals[] = (object) array(
                    'propertyName' =>  $eActionConditional->getValue('entityProperty.name'),
                    'type' =>  $eActionConditional->getValue('type'),
                    'value1' =>  $eActionConditional->getValue('value1'),
                    'value2' =>  $eActionConditional->getValue('value2')
                );
            }

            // d. add settings
            $aActionSettings = $eAction->get('settings');
            $nActionSettingCount = count($aActionSettings);
            for ($nActionSettingIndex = 0; $nActionSettingIndex < $nActionSettingCount; $nActionSettingIndex++)
            {
                // i. register
                $eActionSetting = $aActionSettings[$nActionSettingIndex];

                // ii. build and store
                $actionConfig->settings->{$eActionSetting->get('key')} = $eActionSetting->get('value');
            }

            // e. store
            $aActionConfigs[] = $actionConfig;

        }

        // 4. send
        return $aActionConfigs;
    }
}
