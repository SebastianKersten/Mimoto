<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Data\MimotoEntity;
use Mimoto\library\entities\MimotoEntityUtils;

// Silex classes
use Silex\Application;


/**
 * MimotoAimlessService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessService
{
    
    // services
    private $_MimotoEntityService;
    private $_MimotoAimlessService;
    private $_TwigService;
    
    // config
    var $_aTemplates;
    
    
    
    const DBTABLE_TEMPLATES = '_mimoto_templates';
    const DBTABLE_TEMPLATES_CONDITIONALS = '_mimoto_templates_conditionals';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($MimotoEntityService, $TwigService)
    {
        // register
        $this->_MimotoEntityService = $MimotoEntityService;
        $this->_MimotoAimlessService = $this;
        $this->_TwigService = $TwigService;
        
        // load and register
        $this->_aTemplates = $this->loadTemplates();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create 
     * @param string $sTemplateName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createComponent($sTemplateName, $entity = null)
    {
        // init and send
        return $component = new AimlessComponent($sTemplateName, $entity, $this->_MimotoAimlessService, $this->_TwigService);
    }
    
    
    public function getTemplate($sTemplateName, $entity = null)
    {
        for ($i = 0; $i < count($this->_aTemplates); $i++)
        {
            $template = $this->_aTemplates[$i];
            
            if ($template->name === $sTemplateName)
            {
                if (count($template->conditionals) > 0 && $entity !== null)
                {
                    $bValidated = true;
                    for ($j = 0; $j < count($template->conditionals); $j++)
                    {
                        $conditional = $template->conditionals[$j];
                        
                        if ($entity->getValue($conditional->key) !== $conditional->value)
                        {
                            $bValidated = false;
                            break;
                        }
                    }
                    
                    if ($bValidated) { return $template->file; }
                }
                else
                {
                    return $template->file;
                }
            }
        }
        
        
        die("MimotoAimlessService says: Template '$sTemplateName' not found");
        
        // 1. broadcast webevent for debugging purposes
        // 2. standaard report error (error level)
        
    }
    
    
    
    private function loadTemplates()
    {
        
        // check if in memory, else load from mysql:
        
        
        // init
        $aTemplates = [];
        //$aAllConditionals = [];
        
        
        // load
        $sQueryTemplates = "SELECT * FROM ".self::DBTABLE_TEMPLATES;
        $resultTemplates = mysql_query($sQueryTemplates) or die('Query failed: ' . mysql_error());
        $nTemplateCount = mysql_num_rows($resultTemplates);
        
        // store
        for ($i = 0; $i < $nTemplateCount; $i++)
        {
            $entity = (object) array(
                'id' => mysql_result($resultTemplates, $i, 'id'),
                'name' => mysql_result($resultTemplates, $i, 'name'),
                'file' => mysql_result($resultTemplates, $i, 'file'),
                'owner' => mysql_result($resultTemplates, $i, 'owner'),
                'created' => mysql_result($resultTemplates, $i, 'created'),
                'conditionals' => []
            );
            
            $aTemplates[] = $entity;
        }
        
        // load
        $sQueryConditionals = "SELECT * FROM ".self::DBTABLE_TEMPLATES_CONDITIONALS;
        $resultConditionals = mysql_query($sQueryConditionals) or die('Query failed: ' . mysql_error());
        $nConditionalCount = mysql_num_rows($resultConditionals);
        
        // store
        for ($i = 0; $i < $nConditionalCount; $i++)
        {
            $conditional = (object) array(
                'id' => mysql_result($resultConditionals, $i, 'id'),
                'template_id' => mysql_result($resultConditionals, $i, 'template_id'),
                'key' => mysql_result($resultConditionals, $i, 'key'),
                'value' => mysql_result($resultConditionals, $i, 'value'),
                'created' => mysql_result($resultConditionals, $i, 'created')
            );
            
            for ($j = 0; $j < count($aTemplates); $j++)
            {
                $template = $aTemplates[$j];
                
                if ($template->id === $conditional->template_id)
                {
                    $template->conditionals[] = $conditional;
                }
            }
        }
        
        return $aTemplates;
    }
    
    
    // --- events ---
    
    
    /**
     * Handle event
     */
    public function handleRequest($sRequest, $data, $config)
    {
        
        switch($sRequest)
        {
            case 'dataUpdate':
                
                $this->dataUpdate($data, $config);
                break;
            
            case 'dataCreate':
                
                $this->dataCreate($data, $config);
                break;
            
            
            default:
                
                die("MimotoAimlessService: Unknown request '".$sRequest."'");
        }
    }
    
    /**
     * Get entity template by type and id
     * @param string $sEntityType
     * @param string $sTemplateId
     * @return string The location to the twig template
     */
    public function getEntityTemplateTypeAndId($sEntityType, $sTemplateId)
    {
        // validate
        if (!isset($this->_aEntities[$sEntityType])) { return; }
        
        
        // register
        $entityConfig = $this->_aEntities[$sEntityType];
        
        // load
        $sTemplate = $entityConfig->templates[$sTemplateId];
        
        // send
        return $sTemplate;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Manage data update
     * @param MimotoEntity $entity
     * @param object $config
     */
    private function dataUpdate(MimotoEntity $entity, $config)
    {

        // register
        $nEntityId = $entity->getId();
        $sEntityType = $entity->getEntityType();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // init
        $data->updated = array();
        $aModifiedValues = $entity->getChanges();        
        
        // verify
        if (isset($config->properties))
        {

            // register
            $aConfigProperties = $config->properties;
            $nConfigPropertyCount = count($aConfigProperties);
            
            // load properties
            for ($nConfigPropertyIndex = 0; $nConfigPropertyIndex < $nConfigPropertyCount; $nConfigPropertyIndex++)
            {
                // read
                $sPropertyName = $aConfigProperties[$nConfigPropertyIndex];
                
                
                // find
                $nSeperatorPos = strpos($sPropertyName, '.');
                
                // separate
                $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, 0, $nSeperatorPos) : $sPropertyName;
                $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, $nSeperatorPos + 1) : '';
                
                
                // check if property exists and value modified
                if (!$entity->hasProperty($sMainPropertyName) || !isset($aModifiedValues[$sMainPropertyName])) continue;
                
                
                // init
                $valueForBroadcast = (object) array();
                
                // compose
                $valueForBroadcast->value = $entity->getValue($sMainPropertyName);
                $valueForBroadcast->property = $sPropertyName;
                

                // verify
                if (!empty($sSubPropertyName))
                {
                    // load
                    $subentity = $entity->getValue($sMainPropertyName);
                    
                    // init
                    $valueForBroadcast->origin = (object) array();
                    
                    // validate
                    if (MimotoEntityUtils::isEntity($subentity))
                    {
                        // check if property exists
                        if ($subentity->hasProperty($sSubPropertyName))
                        {
                            // compose
                            $valueForBroadcast->value = $subentity->getValue($sSubPropertyName);   
                            $valueForBroadcast->origin->entityType = $subentity->getEntityType();
                            $valueForBroadcast->origin->entityId = $subentity->getId();
                            $valueForBroadcast->origin->property = $sSubPropertyName;
                        }
                    }
                    else
                    {
                        // compose
                        $valueForBroadcast->origin->entityType = $sMainPropertyName;
                        $valueForBroadcast->origin->property = $sSubPropertyName;
                    }
                }
                
                // store
                $data->updated[] = $valueForBroadcast;
            }
        }
        
        
        // 1. dit gaat via async, het is efficienter om de rest af te handelen via deze directe route (denk aan "modified")
        // 2. handel eerst alles rondom de nieuwe data af!
        
        
        if (!empty($data->updated)) { $this->sendPusherEvent('Aimless', 'data.update', $data); }
        
        //$this->sendPusherEvent('livescreen', 'popup.open', (object) array('url' => '/project/new'));
        //$this->sendPusherEvent('livescreen', 'page.change', (object) array('url' => '/forecast'));
    }
    
    /**
     * Manage data create
     * @param MimotoEntity $entity
     * @param object $config (unused for now)
     */
    private function dataCreate(MimotoEntity $entity, $config)
    {

        // register
        $nEntityId = $entity->getId();
        $sEntityType = $entity->getEntityType();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // send
        $this->sendPusherEvent('Aimless', 'data.create', $data);
    }
    
    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendPusherEvent($sChannel, $sEvent, $data)
    {
        // init
        $client= new \GearmanClient();
        
        // setup
        $client->addServer();
        
        // $result =
        // execute
        $client->doBackground("sendUpdate", json_encode(array(
            'sChannel' => $sChannel,
            'sEvent' => $sEvent,
            'data' => $data
        )));
    }
    
}
