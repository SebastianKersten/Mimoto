<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityService;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Aimless\AimlessComponentViewModel;
use Mimoto\Log\MimotoLogService;


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
    protected $_LogService;
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

    protected $_connection;


    const PRIMARY_FORM = 'primary_form'; // #todo - explain
    const DEFAULT_THEME = 'default_theme'; // #todo - explain



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
    public function __construct($sComponentName, MimotoEntity $entity = null, $connection = null, MimotoAimlessService $AimlessService, MimotoEntityService $DataService, MimotoLogService $LogService, $TwigService)
    {
        // register
        $this->_sComponentName = $sComponentName;
        $this->_entity = $entity;
        $this->_connection = $connection;

        // register
        $this->_AimlessService = $AimlessService;
        $this->_DataService = $DataService;
        $this->_LogService = $LogService;
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

    /**
     * @param $sKey For use in general layouts
     * @param $sFormName
     * @param mixed $xData
     * @param null $sLayout
     * @param null $sComponentName
     */
    public function addForm($sFormName, $xValues = null, $options = null)
    {
        // default
        $sKey = (!empty($options) && !empty($options['key'])) ? $options['key'] : self::PRIMARY_FORM;

        // store
        $this->_aFormConfigs[$sKey] = (object) array(
            'sFormName' => $sFormName,
            'xValues' => $xValues,
            'sLayout' => (!empty($options) && !empty($options['layout'])) ? $options['layout'] : '',
            'sTheme' => (!empty($options) && !empty($options['theme'])) ? $options['theme'] : self::DEFAULT_THEME,
            'options' => $options
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


    public function data($sPropertySelector, $bGetConnectionInfo = false, $bRenderData = false, $sComponentName = null)
    {
        // validate
        if (empty($this->_entity)) error("AimlessComponent says: The entity is not set. Please supply one.");

        // find
        $nSeperatorPos = strpos($sPropertySelector, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, 0, $nSeperatorPos) : $sPropertySelector;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, $nSeperatorPos + 1) : '';


        //$property = $this->getProperty($sPropertySelector);
        //$sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);


        // read and send
        if (!$bRenderData)
        {

            // #todo - in geval van getStructure (connections -> anders oppakken
            // #todo - connections in ViewModel gooien

            return $this->_entity->getValue($sPropertySelector, $bGetConnectionInfo);
        }

        // render
        switch($this->_entity->getPropertyType($sMainPropertyName))
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                // read, render and send
                return $this->renderValueProperty($sMainPropertyName);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                // read, render and send
                return $this->renderEntityProperty($sPropertySelector, $sComponentName);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                // read, render and send
                return $this->renderCollectionProperty($sPropertySelector, $sComponentName);
                break;
        }
    }

    /**
     * Render value property
     * @param $sPropertyName
     * @return mixed
     */
    private function renderValueProperty($sPropertyName)
    {
        // 1. read
        $value = $this->_entity->getValue($sPropertyName);

        // 2. format
        if (isset($this->_aPropertyFormatters[$sPropertyName]))
        {
            // register
            $fDelegate = $this->_aPropertyFormatters[$sPropertyName]->delegate;

            // execute
            $value = $fDelegate($value);
        }

        // 3. send
        return $value;
    }

    /**
     * Render entity property
     * @param string $sPropertySelector
     * @param string $sComponentName
     * @return mixed|string Either a rendered component or a value
     */
    private function renderEntityProperty($sPropertySelector, $sComponentName = null)
    {
        // 1. read
        $xValue = $this->_entity->getValue($sPropertySelector);

        // 2. output if no entity connected or entity's subproperty is empty
        if (empty($xValue)) return '';

        // 3. output if entity's subproperty is a value
        if (!MimotoDataUtils::isEntity($xValue)) return $xValue;

        // 4. verify component
        if (empty($sComponentName))
        {
            if (isset($this->_aPropertyComponents[$sPropertySelector]))
            {
                // 4a. select from config list
                $sComponentName = $this->_aPropertyComponents[$sPropertySelector]->sComponentName;
            }
            else
            {
                // 4b. report missing component
                $GLOBALS['Mimoto.Log']->silent("Missing component while rendering entity-property", "The property <b>$sPropertySelector</b> you are trying to render doens't have a component connected to it.");
                return '';
            }
        }

        // 5. create component
        $component = $this->_AimlessService->createComponent($sComponentName, $xValue);

        // 6. render and send
        return $component->render();
    }

    /**
     * Render collection property
     * @param string $sPropertySelector
     * @param string $sComponentName
     * @return mixed|string Either a rendered component or a value
     */
    private function renderCollectionProperty($sPropertySelector, $sComponentName = null)
    {

        // #todo - double code om $this->_aPropertyComponents[$sMainPropertyName] te laten werken
        // #todo
        // 1. rewrite to function: get propertyname from selector

        // find
        $nSeperatorPos = strpos($sPropertySelector, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, 0, $nSeperatorPos) : $sPropertySelector;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, $nSeperatorPos + 1) : '';

        // #todo - end



        // 1. read
        $xValue = $this->_entity->getValue($sPropertySelector);
        $aConnections = $this->_entity->getValue($sPropertySelector, true);

        // 2. output if collection is empty or entity's subproperty is empty
        if (empty($xValue) || !is_array($xValue) || empty($aConnections) || !is_array($aConnections)) return '';

        // 3. determine
        $sComponentName = (!empty($sComponentName)) ? $sComponentName : $this->_aPropertyComponents[$sMainPropertyName]->sComponentName;

        // 4. render and send
        return $this->renderCollection($xValue, $aConnections, $sComponentName);

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
            $selector = MimotoDataUtils::getConditionalsAndSubselector($sSubpropertySelector);

            // compose
            $sFilter = (!empty($selector->conditionals)) ? " mls_filter='".json_encode($selector->conditionals)."'" : '';


            #component

            if (!empty($this->_entity) && $this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {

                $sComponentName = $this->_aPropertyComponents[$sPropertyName]->sComponentName;
                $sComponentConditionals = $GLOBALS['Mimoto.Aimless']->getComponentConditionalsAsString($sComponentName);
                $sComponentName .= $sComponentConditionals;

                // compose
                $sComponent = (!empty($sComponentName)) ? ' mls_component="'.$sComponentName.'"' : '';

                // send
                return 'mls_contains="'.$this->_entity->getAimlessValue($sPropertyName).'"'.$sFilter.$sComponent;
            }
            else
            if (isset($this->_aSelections[$sPropertyName]))
            {

                $sComponentName = $this->_aSelections[$sPropertyName]->sComponentName;
                $sComponentConditionals = $GLOBALS['Mimoto.Aimless']->getComponentConditionalsAsString($sComponentName);
                $sComponentName .= $sComponentConditionals;

                // compose
                $sComponent = ' mls_component="'.$sComponentName.'"';

                // send
                return 'mls_selection="'.$this->_aSelections[$sPropertyName]->selection->getCriteria()['type'].'"'.$sFilter.$sComponent;
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
            $sConnection = (!empty($this->_connection) && !is_nan($this->_connection->getId())) ? ' mls_connection="'.$this->_connection->getId().'"' : '';
            $sSortIndex = (!empty($this->_connection) && !is_nan($this->_connection->getSortIndex())) ? ' mls_sortindex="'.$this->_connection->getSortIndex().'"' : '';
            $sComponentName = (!empty($this->_sComponentName)) ? ' mls_component="'.$this->_sComponentName.'"' : '';


            return 'mls_id="'.$this->_entity->getAimlessId().'"'.$sConnection.$sSortIndex.$sComponentName;
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
            case 'type': return $this->_entity->getEntityTypeName();
            case 'created': return $this->_entity->getCreated();
        }
    }


    public function form($sKey = null)
    {
        // 1. set default key
        if ($sKey === null) $sKey = self::PRIMARY_FORM;

        // 2. validate is form was defined
        if (!isset($this->_aFormConfigs[$sKey])) die("Aimless says: Form '$sKey' not defined");

        // 3. load requested config
        $formConfig = $this->_aFormConfigs[$sKey];

        // 4. output
        return $this->renderForm($formConfig->sFormName, $formConfig->xValues);
    }


    public function submit($sKey = null)
    {
        // 1. set default key
        if ($sKey === null) $sKey = self::PRIMARY_FORM;

        // 2. validate is form was defined
        if (!isset($this->_aFormConfigs[$sKey])) die("Aimless says: Form '$sKey' not defined");

        // 3. load requested config
        $formConfig = $this->_aFormConfigs[$sKey];

        // 4. output
        return 'mls_form_submit="'.$formConfig->sFormName.'"';
    }

    
    
    public function render()
    {
        // get te component file
        $sComponentFile = $this->_AimlessService->getComponentFile($this->_sComponentName, $this->_entity);

        // create
        $viewModel = new AimlessComponentViewModel($this);

        // compose
        $this->_aVars['Aimless'] = $viewModel;
        
        // output
        return $this->_TwigService->render($sComponentFile, $this->_aVars);
    }


    /**
     * Render a collection with support for regular components and inputs
     * @param $aCollection
     * @param $aConnections #todo - connect id's to subitems
     * @param string $sComponentName
     * @param array $aFieldVars
     * @return string Rendered template
     */
    protected function renderCollection($aCollection, $aConnections, $sComponentName = null, $aFieldVars = null)
    {
        // init
        $sRenderedCollection = '';

        // render
        $nCollectionCount = count($aCollection);
        for ($i = 0; $i < $nCollectionCount; $i++)
        {
            // register
            $entity = $aCollection[$i];

            // register
            $connection = (!empty($aConnections)) ? $aConnections[$i] : null;

            // render
            $sRenderedCollection .= $this->renderCollectionItem($entity, $connection, $sComponentName, $aFieldVars);
        }
        
        // send
        return $sRenderedCollection;
    }

    /**
     * Render collection item
     * @param $aCollection
     * @param $aConnections
     * @param null $sComponentName
     * @param null $aFieldVars
     * @return string
     */
    private function renderCollectionItem($entity, $connection, $sComponentName = null, $aFieldVars = null)
    {
        // revert to default
        $sTemplateName = (!empty($sComponentName)) ? $sComponentName : $entity->getEntityTypeName();

        // create
        if ($entity->typeOf(CoreConfig::MIMOTO_FORM_INPUT))
        {
            $component = $this->renderCollectionItemAsInput($sTemplateName, $entity, $connection, $aFieldVars);
        }
        else
        {
            $component = $this->renderCollectionItemAsComponent($sTemplateName, $entity, $connection);
        }

        // forward
        foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }

        // output
        return $component->render();
    }

    /**
     * Render collection item as AimlessComponent
     * @param $sTemplateName
     * @param $entity
     * @return AimlessComponent
     */
    private function renderCollectionItemAsComponent($sTemplateName, $entity, $connection)
    {
        // create and send
        return $this->_AimlessService->createComponent($sTemplateName, $entity, $connection);
    }

    /**
     * Render collection item as AimlessInput
     * @param $sTemplateName
     * @param $field
     * @param $aFieldVars
     * @return AimlessInput
     */
    private function renderCollectionItemAsInput($sTemplateName, $field, $connection, $aFieldVars)
    {
        // validate
        if (!isset($aFieldVars[$field->getEntityTypeName().'.'.$field->getId()]))
        {
            $this->_LogService->error('AimlessComponent - Form field misses a value definition', "The field with type=".$field->getEntityTypeName()." and <b>id=".$field->getId()."</b> is missing a value definition. Please set the value property set a <b>varname</b> or connect an <b>entityProperty</b>", 'AimlessComponent', true);
        }

        // gerister
        $fieldVar = $aFieldVars[$field->getEntityTypeName().'.'.$field->getId()];

        // #todo

        if ($field->getEntityTypeName() == CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN)
        {
            $fieldValue = $field->getValue('value');
            $aFieldValueOptions = $fieldValue->getValue('options', true);

            //error($aFieldValueOptions);
        }

        // create and send
        return $this->_AimlessService->createInput($sTemplateName, $field, $connection, $fieldVar->key, $fieldVar->value);
    }

    /**
     * Render a form
     * @param $sFormName
     * @param $xValues
     * @return string
     */
    private function renderForm($sFormName, $xValues)
    {
        // create
        $component = $this->_AimlessService->createForm($sFormName, $xValues);

        // output
        return $component->render(); //$this->_aVars); // #todo - pass vars for rendering
    }
    
}
