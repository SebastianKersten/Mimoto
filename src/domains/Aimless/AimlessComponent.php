<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Data\MimotoEntityService;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * AimlessComponent
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponent
{
    
    // services
    protected $_AimlessService;
    protected $_DataService;
    protected $_TwigService;
    
    // data
    protected $_entity;
    
    // settings
    protected $_sComponentName;
    
    // config
    protected $_aVars = [];
    protected $_aSelections = [];
    protected $_aFormConfigs = [];
    protected $_aPropertyComponents = [];
    protected $_aPropertyFormatters = [];

    protected $_nConnectionId;
    protected $_nSortIndex;


    const PRIMARY_FORM = 'primary_form'; // #todo - explain



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------s
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param AimlessService $AimlessService
     * @param MimotoEntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sComponentName, MimotoEntity $entity = null, MimotoAimlessService $AimlessService, MimotoEntityService $DataService, $TwigService)
    {
        // register
        $this->_sComponentName = $sComponentName;
        $this->_entity = $entity;
        
        // register
        $this->_AimlessService = $AimlessService;
        $this->_DataService = $DataService;
        $this->_TwigService = $TwigService;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Setup -------------------------------------------------
    // ----------------------------------------------------------------------------


    public function setPropertyComponent($sKey, $sComponentName)
    {
        $propertyComponent = (object) array(
            'sComponentName' => $sComponentName
        );
        
        $this->_aPropertyComponents[$sKey] = $propertyComponent;
    }
    
    
    public function setPropertyFormatter($sKey, $fDelegate)
    {
        $propertyFormatter = (object) array(
            'delegate' => $fDelegate
        );
        
        $this->_aPropertyFormatters[$sKey] = $propertyFormatter;
    }
    
    public function setVar($sKey, $value)
    {
        // register
        $this->_aVars[$sKey] = $value;
    }
    
    public function addSelection($sKey, $sComponentName, $aSelection)
    {
        $this->_aSelections[$sKey] = (object) array(
            'sComponentName' => $sComponentName,
            'selection' => $aSelection
        );
    }

    public function addForm($sFormName, $sComponentName, $entity, $sKey = null)
    {
        // default
        if ($sKey === null) $sKey = self::PRIMARY_FORM;



        // store
        $this->_aFormConfigs[$sKey] = (object) array(
            'sFormName' => $sFormName,
            'sComponentName' => $sComponentName,
            'aData' => $entity // #todo - array met entities
        );
    }




    public function markComponentAsConnectedItem($nConnectionId, $nSortIndex)
    {
        $this->_nConnectionId = $nConnectionId;
        $this->_nSortIndex = $nSortIndex;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------



    // --- Twig usage


    public function data($sPropertyName)
    {
        // validate
        if (empty($this->_entity)) return;



        // 1. subpropertyname (selector-query)



        // read
        $value = $this->_entity->getValue($sPropertyName, true);
        
        
        // verify
        if (is_array($value))
        {

            $aCollection = $value;
            $aConnections = null;
            //$aConnections = $this->_entity->getValue($sPropertyName); // #todo - kan niet, filter check wordt gedaan ná ophalen data en op basis van de data

            $nSeparatorPos = strpos($sPropertyName, '.');
            if ($nSeparatorPos !== false) { $sPropertyName = substr($sPropertyName, 0, $nSeparatorPos); }
            
            
            if (!isset($this->_aPropertyComponents[$sPropertyName]))
            {
                return "Aimless says: No component set for property '$sPropertyName'. Use AimlessComponent->setPropertyComponent()";
                
                // 1. broadcast webevent for debugging purposes
                // 2. standaard report error (error level)
            }
            
            // render and send
            return $this->renderCollection($aCollection, $aConnections, $this->_aPropertyComponents[$sPropertyName]->sComponentName);
        }
        else
        {
            // format
            if (isset($this->_aPropertyFormatters[$sPropertyName]))
            {
                $fDelegate = $this->_aPropertyFormatters[$sPropertyName]->delegate;
                
                $value = $fDelegate($value);
            }
            
            //if (isset($this->_aPropertyComponents[$sPropertyName]))
            //{
                
                // 1. check if is entity instanceof MimotoEntity
                // 2. wrap in component
                
                
                // get te
            //    $sComponentFile = $this->_AimlessService->getComponent($this->_sComponentName, $this->_entity);
                
            //}
            //else
            //{
                // send
                return $value;
            //}
        }
    }
    
    public function selection($sSelectionName)
    {
        // validate
        if (!isset($this->_aSelections[$sSelectionName])) die("Aimless says: Selection '$sSelectionName' not defined");

        // load
        $selection = $this->_aSelections[$sSelectionName];
        
        // render and send
        return $this->renderCollection($selection->selection, null, $selection->sComponentName);
    }


    public function realtime($sPropertySelector = null)
    {
        if ($sPropertySelector !== null)
        {
            // cleanup
            $nSeparatorPos = strpos($sPropertySelector, '.');
            $sPropertyName = ($nSeparatorPos !== false) ? substr($sPropertySelector, 0, $nSeparatorPos) :  $sPropertySelector;
            
            $sSubpropertySelector = substr($sPropertySelector, $nSeparatorPos + 1);
            $aConditionals = MimotoDataUtils::getConditionals($sSubpropertySelector);

            // compose
            $sFilter = (!empty($aConditionals)) ? " mls_filter='".json_encode($aConditionals)."'" : '';

            if (!empty($this->_entity) && $this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {
                // compose
                $sComponent = (!empty($this->_aPropertyComponents[$sPropertyName]->sComponentName)) ? ' mls_component="'.$this->_aPropertyComponents[$sPropertyName]->sComponentName.'"' : '';

                // send
                return 'mls_contains="'.$this->_entity->getAimlessValue($sPropertyName).'"'.$sFilter.$sComponent;
            }
            else
            if (isset($this->_aSelections[$sPropertyName]))
            {
                // compose
                $sComponent = ' mls_component="'.$this->_aSelections[$sPropertyName]->sComponentName.'"';

                // send
                return 'mls_contains="'.$this->_aSelections[$sPropertyName]->selection->getCriteria()['type'].'"'.$sFilter.$sComponent;
            }
                
        }
        
        
        if (empty($this->_entity))
        {
            die("Aimless says: Realtime feature for property '$sPropertySelector' not possible if no entity is set");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }
            
            
        if ($sPropertySelector === null)
        {
            $sConnection = (!empty($this->_nConnectionId)) ? ' mls_connection="'.$this->_nConnectionId.'"' : '';
            $sSortIndex = (!empty($this->_nSortIndex)) ? ' mls_sortindex="'.$this->_nSortIndex.'"' : '';

            return 'mls_id="'.$this->_entity->getAimlessId().'"'.$sConnection.$sSortIndex;
        }
        else
        {
            return 'mls_value="'.$this->_entity->getAimlessValue($sPropertySelector).'"';
        }
    }
    
    
    
    /**
     * Get entity's meta information 'id' or 'created'
     * @param type $sPropertyName The entity's meta information 'id' or 'created'
     * @return string
     */
    public function meta($sPropertyName)
    {
        // validate
        if (empty($this->_entity)) return;


        switch(strtolower($sPropertyName))
        {
            case 'id': return $this->_entity->getId();
            case 'type': return $this->_entity->getEntityType();
            case 'created': return $this->_entity->getCreated();
        }
    }
    
    
    public function setupProperty()
    {
        // connect Entity-component to entity
    }
    
    
    
    public function render()
    {
        // get te
        $sComponentFile = $this->_AimlessService->getComponent($this->_sComponentName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;
        
        // output
        return $this->_TwigService->render($sComponentFile, $this->_aVars);
    }
    
    
    
    private function renderCollection($aCollection, $aConnections, $sComponentName)
    {
        // init
        $sRenderedCollection = '';

        for ($i = 0; $i < count($aCollection); $i++)
        {
            // register
            $entity = $aCollection[$i];

            // create
            $component = $this->_AimlessService->createComponent($sComponentName, $entity);

            // 1. #todo get info based upon know data
            // output('Connection '.$i, $aConnections);
            // output('ID', $aConnections[$i]->getId());
            // setup
            //if (!empty($aConnections)) $component->markComponentAsConnectedItem($aConnections[$i]->getId(), $aConnections[$i]->getSortIndex());

            // forward
            foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }
            
            // output
            $sRenderedCollection .= $component->render();
        }
        
        // send
        return $sRenderedCollection;
    }
    
}
