<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\EntityService;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Log\LogService;


/**
 * AimlessComponent
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponent
{
    
    // services
    protected $_OutputService;
    protected $_DataService;
    protected $_LogService;
    protected $_TwigService;
    
    // data
    protected $_entity;
    
    // settings
    protected $_sComponentName;
    protected $_sWrapperName;
    
    // config
    protected $_aVars = [];
    protected $_aSelections = [];
    protected $_aFormConfigs = [];
    protected $_aRegisteredComponents = [];
    protected $_aPropertyComponents = [];
    protected $_aPropertyFormatters = [];
    protected $_mapping;

    protected $_connection;


    const PRIMARY_FORM = 'primary_form'; // #todo - explain
    const DEFAULT_THEME = 'default_theme'; // #todo - explain



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function setMapping($mapping)
    {
        // store
        $this->_mapping = $mapping;
    }

    public function getEntity()
    {
        return $this->_entity;
    }


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param OutputService $OutputService
     * @param EntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sComponentName, MimotoEntity $entity = null, $connection = null, $sWrapperName = null, OutputService $OutputService, EntityService $DataService, LogService $LogService, $TwigService)
    {
        // register
        $this->_sComponentName = $sComponentName;
        $this->_entity = $entity;
        $this->_connection = $connection;
        $this->_sWrapperName = $sWrapperName;

        // register
        $this->_OutputService = $OutputService;
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
    
    public function addSelection($sKey, $aEntities, $sComponentName = null)
    {
        // #todo - check for double property name | or separate selections from collections


        $this->_aSelections[$sKey] = (object) array(
            'sComponentName' => $sComponentName,
            'aEntities' => $aEntities
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

    public function addComponent($sComponentAlias, AimlessComponent $component, $options = null)
    {
        // store
        $this->_aRegisteredComponents[$sComponentAlias] = (object) array(
            'component' => $component,
            'options' => $options
        );
    }


    public function markComponentAsConnectedItem($nConnectionId, $nSortIndex)
    {
        $this->_nConnectionId = $nConnectionId;
        $this->_nSortIndex = $nSortIndex;
    }



    public function getConnectionId()
    {
        return (!empty($this->_connection)) ? $this->_connection->getId() : '';
    }

    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------



    // --- Twig usage


    public function data($sPropertySelector, $bGetConnectionInfo = false, $bRenderData = false, $sComponentName = null, $sWrapperName = null, $customValues = null)
    {
        // find
        $nSeperatorPos = strpos($sPropertySelector, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, 0, $nSeperatorPos) : $sPropertySelector;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, $nSeperatorPos + 1) : '';


        //$property = $this->getProperty($sPropertySelector);
        //$sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);


        if (!empty($this->_entity))
        {

            // read and send
            if (!$bRenderData)
            {

                // #todo - in geval van getStructure (connections -> anders oppakken
                // #todo - connections in ViewModel gooien

                return $this->_entity->getValue($sPropertySelector, $bGetConnectionInfo);
            }


            // convert via mapping
            if (!empty($this->_mapping)) $sMainPropertyName = $this->_mapping[$sMainPropertyName];


            if ($this->_entity->hasProperty($sMainPropertyName))
            {

                // render
                switch ($this->_entity->getPropertyType($sMainPropertyName))
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                        // read, render and send
                        return $this->renderValueProperty($sMainPropertyName);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // read, render and send
                        return $this->renderEntityProperty($sPropertySelector, $sComponentName, $sWrapperName, $customValues);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // read, render and send
                        return $this->renderCollectionProperty($sPropertySelector, $sComponentName, $sWrapperName, $customValues);
                        break;
                }
            }
        }

        if (isset($this->_aSelections[$sMainPropertyName]))
        {
            // load
            $selection = $this->_aSelections[$sMainPropertyName];


            if (empty($sComponentName))
            {
                if (isset($selection->sComponentName))
                {
                    $sComponentName = $selection->sComponentName;
                }
            }

            // render and send
            return $this->renderCollection($selection->aEntities, null, $sComponentName);
        }

        // report missing property
        Mimoto::service('log')->silent("Property or selection not found", "The property or selection with name <b>$sMainPropertyName</b> doens't seem to be available.");
        return '';
    }

    public function getValueBySortindex($nIndex = 0, $bGetRealtime = false, $bGetImage = false)
    {
        // read
        $aPropertyNames = $this->_entity->getPropertyNames();

        // search
        $nFoundPropertyIndex = 0;
        $nPropertyCount = count($aPropertyNames);
        for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
        {
            // register
            $sPropertyName = $aPropertyNames[$nPropertyIndex];

            if ($bGetImage)
            {
                if ($this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY &&
                    $this->_entity->getPropertySubtype($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE)
                {
                    // verify
                    if ($nFoundPropertyIndex == $nIndex)
                    {
                        return ($bGetRealtime) ? $this->realtime($sPropertyName) : $this->data($sPropertyName, false, true);
                    }
                    else
                    {
                        // update
                        $nFoundPropertyIndex++;
                    }
                }
            }
            else
            {
                // verify
                if ($this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                {
                    // verify
                    if ($nFoundPropertyIndex == $nIndex)
                    {
                        return ($bGetRealtime) ? $this->realtime($sPropertyName) : $this->data($sPropertyName, false, true);
                    } else
                    {
                        // update
                        $nFoundPropertyIndex++;
                    }
                }
            }
        }

        // send default
        return '';
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
    private function renderEntityProperty($sPropertySelector, $sComponentName = null, $customValues = null)
    {
        // special render output
        switch($this->_entity->getPropertySubtype($sPropertySelector))
        {
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                // read
                $eFile = $this->_entity->getValue($sPropertySelector);

                if (!empty($eFile))
                {
                    // compose and send
                    return Mimoto::value('config')->general->public_root.$eFile->getValue('path').$eFile->getValue('name');
                }
                else
                {
                    return '';
                }
        }


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
                Mimoto::service('log')->silent("Missing component while rendering entity-property", "The property <b>$sPropertySelector</b> you are trying to render doens't have a component connected to it.");
                return '';
            }
        }

        // 5. create component
        $component = $this->_OutputService->createComponent($sComponentName, $xValue);

        // 6. render and send
        return $component->render($customValues);
    }

    /**
     * Render collection property
     * @param string $sPropertySelector
     * @param string $sComponentName
     * @return mixed|string Either a rendered component or a value
     */
    private function renderCollectionProperty($sPropertySelector, $sComponentName = null, $sWrapperName = null, $customValues = null)
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
        if (empty($sComponentName))
        {
            if (isset($this->_aPropertyComponents[$sMainPropertyName]))
            {
                $this->_aPropertyComponents[$sMainPropertyName]->sComponentName;
            }
        }

        // 4. render and send
        return $this->renderCollection($xValue, $aConnections, $sComponentName, null, null, $sWrapperName, $customValues);

    }

    
    public function selection($sSelectionName)
    {
        // validate
        if (!isset($this->_aSelections[$sSelectionName])) die("Mimoto says: Selection '$sSelectionName' not defined");

        // load
        $selection = $this->_aSelections[$sSelectionName];
        
        // render and send
        return $this->renderCollection($selection->aEntities, null, $selection->sComponentName);
    }


    public function realtime($sPropertySelector = null, $sComponentName = null, $sWrapperName = null)
    {
        $sConnection = (!empty($this->_connection) && !is_nan($this->_connection->getId())) ? ' data-mimoto-connection="'.$this->_connection->getId().'"' : '';
        $sSortIndex = (!empty($this->_connection) && !is_nan($this->_connection->getSortIndex())) ? ' data-mimoto-sortindex="'.$this->_connection->getSortIndex().'"' : '';

        if ($sPropertySelector !== null)
        {
            // cleanup
            $nSeparatorPos = strpos($sPropertySelector, '.');
            $sPropertyName = ($nSeparatorPos !== false) ? substr($sPropertySelector, 0, $nSeparatorPos) :  $sPropertySelector;
            
            $sSubpropertySelector = substr($sPropertySelector, $nSeparatorPos + 1);
            $selector = MimotoDataUtils::getConditionalsAndSubselector($sSubpropertySelector);

            // compose
            $sFilter = (!empty($selector->conditionals)) ? " data-mimoto-filter='".json_encode($selector->conditionals)."'" : '';


            #component

            if (!empty($this->_entity) && $this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {
                if (empty($sComponentName))
                {
                    if (isset($this->_aPropertyComponents[$sPropertyName]))
                    {
                        $sComponentName = $this->_aPropertyComponents[$sPropertyName]->sComponentName;
                    }
                }

                $sComponentConditionals = Mimoto::service('output')->getComponentConditionalsAsString($sComponentName);
                $sComponentName .= $sComponentConditionals;

                // compose
                $sComponent = (!empty($sComponentName)) ? ' data-mimoto-component="'.$sComponentName.'"' : '';
                $sWrapper = (!empty($sWrapperName)) ? ' data-mimoto-wrapper="'.$sWrapperName.'"' : '';

                // send
                return 'data-mimoto-contains="'.$this->_entity->getAimlessValue($sPropertyName).'"'.$sFilter.$sComponent.$sWrapper;
            }
            else
            if (isset($this->_aSelections[$sPropertyName]))
            {
                if (empty($sComponentName))
                {
                    if (isset($this->_aSelections[$sPropertyName]))
                    {
                        $sComponentName = $this->_aSelections[$sPropertyName]->sComponentName;
                    }
                }

                $sComponentConditionals = Mimoto::service('output')->getComponentConditionalsAsString($sComponentName);
                $sComponentName .= $sComponentConditionals;

                // compose
                $sComponent = ' data-mimoto-component="'.$sComponentName.'"';
                $sWrapper = (!empty($sWrapperName)) ? ' data-mimoto-wrapper="'.$sWrapperName.'"' : '';

                // send
                //return 'data-mimoto-selection="'.$this->_aSelections[$sPropertyName]->aEntities->getCriteria()['type'].'"'.$sFilter.$sComponent.$sWrapper;
                return $sConnection.$sSortIndex.$sFilter.$sComponent.$sWrapper; // #todo - fix selections
            }

        }
        
        
        if (empty($this->_entity))
        {
            die("Mimoto says: Realtime feature for property '$sPropertySelector' not possible if no entity is set");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }


        if ($sPropertySelector === null)
        {
            $sComponent = (!empty($this->_sComponentName)) ? ' data-mimoto-component="'.$this->_sComponentName.'"' : '';
            $sWrapper = (!empty($this->_sWrapperName)) ? ' data-mimoto-wrapper="'.$this->_sWrapperName.'"' : '';


            return 'data-mimoto-id="'.$this->_entity->getAimlessId().'"'.$sConnection.$sSortIndex.$sComponent.$sWrapper;
        }
        else
        {
            // compose
            switch ($this->_entity->getPropertyType($sPropertySelector))
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    // 1. check if component was set todo


                    if ($this->_entity->getPropertySubtype($sPropertySelector) == MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE
                        && empty($sComponentName))
                    {
                        return 'data-mimoto-image="'.$this->_entity->getAimlessValue($sPropertySelector).'"';
                    }
                    else
                    {
                        $sComponentName = (!empty($sComponentName)) ? $sComponentName : $this->_aPropertyComponents[$sPropertyName]->sComponentName;

                        $sComponent = (!empty($sComponentName)) ? ' data-mimoto-component="'.$sComponentName.'"' : '';
                        $sWrapper = (!empty($sWrapperName)) ? ' data-mimoto-wrapper="'.$sWrapperName.'"' : '';

                        return 'data-mimoto-entity="'.$this->_entity->getAimlessValue($sPropertySelector).'"'.$sConnection.$sSortIndex.$sComponent.$sWrapper;
                    }

                    break;

                default:

                    return 'data-mimoto-value="'.$this->_entity->getAimlessValue($sPropertySelector).'"';
            }
        }
    }

    public function jsListen($sPropertySelector, $scope, $fJavascriptDelegate)
    {
        if ($sPropertySelector !== null && $fJavascriptDelegate !== null)
        {
            // cleanup
            $nSeparatorPos = strpos($sPropertySelector, '.');
            $sPropertyName = ($nSeparatorPos !== false) ? substr($sPropertySelector, 0, $nSeparatorPos) : $sPropertySelector;

            return 'Mimoto.Aimless.listen("'.$this->_entity->getEntityTypeName().'.'.$this->_entity->getId().'.'.$sPropertyName.'", '.$scope.', '.$fJavascriptDelegate.');';
        }

        return '';
    }

    public function editable($sPropertySelector, $options = null)
    {
        // 1. check global settings
        // 2. return mls identifier from class
        // 3. create js module
        // 4. convert options to json

        if (!empty($sPropertySelector))
        {
            // cleanup
            $nSeparatorPos = strpos($sPropertySelector, '.');
            $sPropertyName = ($nSeparatorPos !== false) ? substr($sPropertySelector, 0, $nSeparatorPos) : $sPropertySelector;

            // 1. forward
            // 2. centralize forward

            // init
            $aimlessTags = new AimlessTags($this->_entity);

            // setup
            $aimlessTags->setEdit($sPropertyName, $options);

            // send
            return $aimlessTags->render();
        }

        // send
        return '';
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
            case 'typeid': return $this->_entity->getEntityTypeId();
            case 'created': return $this->_entity->getCreated();
        }
    }

    /**
     * Get the current user
     * @return UserViewModel
     */
    public function user()
    {
        // init
        $eUser = Mimoto::currentUser();

        // validate
        if (empty($eUser)) return null;

        // create
        $component = Mimoto::service('output')->createComponent('', $eUser);

        // wrap into viewmodel
        $viewModel = new UserViewModel($component);

        // send
        return $viewModel;
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
        return $this->renderForm($formConfig->sFormName, $formConfig->xValues, $formConfig->options);
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
        return 'data-mimoto-form-submit="'.$formConfig->sFormName.'"';
    }

    
    
    public function render($customValues = null)
    {
        if (!empty($this->_sWrapperName))
        {
            // get component file
            $sWrapperFile = $this->_OutputService->getComponentFile($this->_sWrapperName, $this->_entity);

            // create
            $viewModel = new AimlessWrapperViewModel($this, $this->_sComponentName);

            // compose
            $this->_aVars['Mimoto'] = $viewModel;

            // add custom values
            if (!empty($customValues))
            {
                foreach ($customValues as $key => $value)
                {
                    $this->_aVars[$key] = $value;
                }
            }

            // output
            return $this->_TwigService->render($sWrapperFile, $this->_aVars);
        }
        else
        {
            return $this->renderComponent($this->_sComponentName, $customValues);
        }
    }

    public function wrap($sComponentName)
    {
        return $this->renderComponent($sComponentName);
    }

    public function component($sComponentAlias)
    {
        // validate
        if (!isset($this->_aRegisteredComponents[$sComponentAlias]))
        {
            // notify
            Mimoto::service('log')->silent('Page unable to render component', "A The component with alias '".$sComponentAlias."' on a page I'm trying to render seems to be undefined.");

            // send (continue by skipping this component)
            return '';
        }

        // register
        $component = $this->_aRegisteredComponents[$sComponentAlias]->component;
        $options = $this->_aRegisteredComponents[$sComponentAlias]->options;

        // send
        return $component->render($options);
    }

    private function renderComponent($sComponentName, $customValues = null)
    {
        // revert to default
        $sTemplateName = (!empty($sComponentName)) ? $sComponentName : $this->_entity->getEntityTypeName();

        // get component file
        $sComponentFile = $this->_OutputService->getComponentFile($sTemplateName, $this->_entity);

        // create
        $viewModel = new AimlessComponentViewModel($this);

        // compose
        $this->_aVars['Mimoto'] = $viewModel;

        // add custom values
        if (!empty($customValues))
        {
            foreach ($customValues as $key => $value)
            {
                $this->_aVars[$key] = $value;
            }
        }

        // output
        return $this->_TwigService->render($sComponentFile, $this->_aVars);
    }


    public function module($sModuleName, $customValues = null)
    {
        // get module file
        $sModuleFile = $this->_OutputService->getComponentFile($sModuleName);

        // create
        $viewModel = new AimlessModuleViewModel($this);

        // compose
        $this->_aVars['Mimoto'] = $viewModel;

        // add custom values
        if (!empty($customValues))
        {
            foreach ($customValues as $key => $value)
            {
                $this->_aVars[$key] = $value;
            }
        }

        // output
        return $this->_TwigService->render($sModuleFile, $this->_aVars);
    }


    /**
     * Render a collection with support for regular components and inputs
     * @param $aCollection
     * @param $aConnections #todo - connect id's to subitems
     * @param string $sComponentName
     * @param array $aFieldVars
     * @return string Rendered template
     */
    protected function renderCollection($aCollection, $aConnections, $sComponentName = null, $aFieldVars = null, $bRenderInputFieldsAsInput = false, $sWrapperName = null, $customValues = null)
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
            $connection = (!empty($aConnections) && !empty($aConnections[$i])) ? $aConnections[$i] : null;

            // render
            $sRenderedCollection .= $this->renderCollectionItem($entity, $connection, $sComponentName, $aFieldVars, $bRenderInputFieldsAsInput, $sWrapperName, $customValues);
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
    private function renderCollectionItem($entity, $connection, $sComponentName = null, $aFieldVars = null, $bRenderInputFieldsAsInput = false, $sWrapperName = null, $customValues = null)
    {
        // revert to default
        $sTemplateName = (!empty($sComponentName)) ? $sComponentName : $entity->getEntityTypeName();


        // 1. error when missing template


        // create
        if ($bRenderInputFieldsAsInput && $entity->typeOf(CoreConfig::MIMOTO_FORM_INPUT))
        {
            $component = $this->renderCollectionItemAsInput($sTemplateName, $entity, $connection, $aFieldVars);
        }
        else
        {
            if (!empty($sWrapperName))
            {
                $component = $this->renderCollectionItemAsComponentWrapper($sTemplateName, $entity, $connection, $sWrapperName);
            }
            else
            {
                $component = $this->renderCollectionItemAsComponent($sTemplateName, $entity, $connection);
            }
        }

        // forward
        foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }

        // output
        return $component->render($customValues);
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
        return $this->_OutputService->createComponent($sTemplateName, $entity, $connection);
    }

    /**
     * Render collection item as AimlessComponent
     * @param $sTemplateName
     * @param $entity
     * @return AimlessComponent
     */
    private function renderCollectionItemAsComponentWrapper($sComponentName, $entity, $connection, $sWrapperName)
    {
        // create and send
        return $this->_OutputService->createWrapper($sWrapperName, $sComponentName, $entity, $connection);
    }

    /**
     * Render collection item as AimlessInput
     * @param $sTemplateName
     * @param $field
     * @param $aFieldVars
     * @return AimlessInput
     */
    private function renderCollectionItemAsInput($sTemplateName, $eField, $connection, $aFormFields)
    {
        // init
        $bFormFieldFound = false;

        // search
        $nFormFieldCount = count($aFormFields);
        for ($nFormFieldIndex = 0; $nFormFieldIndex < $nFormFieldCount; $nFormFieldIndex++)
        {
            // register
            $formField = $aFormFields[$nFormFieldIndex];

            // check
            if ($formField->fieldSelector == $eField->getEntityTypeName().'.'.$eField->getId())
            {
                // toggle
                $bFormFieldFound = true;
                break;
            }
        }

        // validate
        if (!$bFormFieldFound) $this->_LogService->error('AimlessComponent - Form field misses a value specification', "Please add a value to input field with <b>id=".$eField->getId()."</b> and type=".$eField->getEntityTypeName(), 'AimlessComponent', true);

        // create and send
        return $this->_OutputService->createInput($sTemplateName, $eField, $connection, $formField->key, $formField->value);
    }

    /**
     * Render a form
     * @param $sFormName
     * @param $xValues
     * @return string
     */
    private function renderForm($sFormName, $xValues, $options)
    {
        // create
        $component = $this->_OutputService->createForm($sFormName, $xValues, $options);

        // output
        return $component->render(); //$this->_aVars); // #todo - pass vars for rendering
    }



    public function isEmpty($sPropertySelector)
    {
        if (isset($this->_entity) && $this->hasProperty($sPropertySelector))
        {
            return empty($this->data($sPropertySelector));
        }
        else
        {
            if (isset($this->_aSelections[$sPropertySelector]))
            {
                return $this->_aSelections[$sPropertySelector]->aEntities->isEmpty();
            }
        }

        return true;
    }


    public function hideWhenEmpty($sPropertySelector)
    {

        if (isset($this->_entity) && $this->hasProperty($sPropertySelector))
        {
            $sDisplayState = (empty($this->data($sPropertySelector))) ? 'style="display:none"' : '';

            return 'data-mimoto-hideonempty="'.$this->_entity->getAimlessId().'.'.$sPropertySelector.'" '.$sDisplayState;
        }
        else
        {
            if (isset($this->_aSelections[$sPropertySelector]))
            {
                $sDisplayState = ($this->_aSelections[$sPropertySelector]->aEntities->isEmpty()) ? 'style="display:none"' : '';

                return 'data-mimoto-hideonempty="'.$sPropertySelector.'" '.$sDisplayState;
            }
        }

        return '';
    }

    public function showWhenEmpty($sPropertySelector)
    {

//            // cleanup
//            $nSeparatorPos = strpos($sPropertySelector, '.');
//
//
//        $sSubpropertySelector = substr($sPropertySelector, $nSeparatorPos + 1);
//        $selector = MimotoDataUtils::getConditionalsAndSubselector($sSubpropertySelector);
//
//            // compose
//            $sFilter = (!empty($selector->conditionals)) ? " data-mimoto-filter='".json_encode($selector->conditionals)."'" : '';



        if (isset($this->_entity) && $this->hasProperty($sPropertySelector))
        {
            $sDisplayState = (!empty($this->data($sPropertySelector))) ? 'style="display:none"' : '';

            return 'data-mimoto-showonempty="'.$this->_entity->getAimlessId().'.'.$sPropertySelector.'" '.$sDisplayState;
        }
        else
        {
            if (isset($this->_aSelections[$sPropertySelector]))
            {
                $sDisplayState = (!$this->_aSelections[$sPropertySelector]->aEntities->isEmpty()) ? 'style="display:none"' : '';

                return 'data-mimoto-showonempty="'.$sPropertySelector.'" '.$sDisplayState;
            }
        }

        return '';
    }

    public function reloadOnChange()
    {
        return 'data-mimoto-reloadonchange="true"';
    }

    public function hasProperty($sPropertyName)
    {
        return $this->_entity->hasProperty($sPropertyName);
    }

    public function typeOf($sEntityTypeName)
    {
        return $this->_entity->typeOf($sEntityTypeName);
    }

}
