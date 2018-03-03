<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\EntityConfigTableUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;

// ElephantIO classes
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
use ElephantIO\Exception\ServerConnectionFailureException;


class CoreRealtime // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('CoreData');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }


    /**
     * Handle formatting updates
     * @param MimotoEntity $eEntityPropertySetting
     */
    public function onFormattingChanged(MimotoEntity $eEntityPropertySetting)
    {
        // 1. verify
        if ($eEntityPropertySetting->getValue('key') != EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS) return;

        // 2. get the setting's property
        $eEntityProperty = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_ENTITYPROPERTY, CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings', $eEntityPropertySetting);

        // 3. get the property's entity
        $eEntity = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eEntityProperty);

        // 4. compose memcache key
        $sKeyFormattingOptions = EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS.':'.$eEntity->getValue('name').'.'.$eEntityProperty->getValue('name');

        // 5. store in cache
        if (Mimoto::service('cache')->isEnabled())
        {
            Mimoto::service('cache')->setValue($sKeyFormattingOptions, json_encode(FormattingUtils::composeFormattingOptions($eEntityPropertySetting)));
        }


        // setup socket connection
        $client = new Client(new Version1X(Mimoto::value('config')->socketio->workergateway));

        try
        {
            // broadcast update
            $client->initialize();
            $client->emit('formattingOptions.changed', ['entityName' => $eEntity->getValue('name'), 'entityPropertyName' => $eEntityProperty->getValue('name')]);
            $client->close();
        }
        catch (ServerConnectionFailureException $e)
        {
            echo 'Server Connection Failure!!';
        }
    }

}