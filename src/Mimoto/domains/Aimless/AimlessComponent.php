<?php

// classpath
namespace Mimoto\Aimless;


/**
 * AimlessComponent
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponent
{
    
    // services
    var $_AimlessService;
    var $_TwigService;
    
    // data
    var $_entity;
    
    // settings
    var $_sTemplateName;
    
    // config
    var $_aVars = [];
    var $_aCollections = [];
    var $_aPropertyTemplates = [];
    var $_aPropertyFormatters = [];
    
    
    
    /**
     * Constructor
     * @param type $sViewmodelName
     * @param type $entity
     */
    public function __construct($sTemplateName, $entity, $AimlessService, $TwigService)
    {
        // register
        $this->_sTemplateName = $sTemplateName;
        $this->_entity = $entity;
        
        // register
        $this->_AimlessService = $AimlessService;
        $this->_TwigService = $TwigService;
    }
    
    public function setPropertyTemplate($sKey, $sTemplateName)
    {
        $propertyTemplate = (object) array(
            'template_name' => $sTemplateName
        );
        
        $this->_aPropertyTemplates[$sKey] = $propertyTemplate;
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
    
    public function addCollection($sKey, $sTemplateName, $aCollection)
    {
        $collection = (object) array(
            'template_name' => $sTemplateName,
            'collection' => $aCollection
        );
        
        $this->_aCollections[$sKey] = $collection;
    }
    
    
    // --- Twig usage
    
    public function data($sPropertyName)
    {
        
        // 1. subpropertyname (selector-query)
        
        // read
        $value = $this->_entity->getValue($sPropertyName, true);
        
        
        // verify
        if (is_array($value))
        {
            
            //echo '######';
            
            
            // 5. MimotoData check if collection item already loaded
            
            //echo '<pre>';
            //print_r($value);
            //echo '</pre>';
            
            
            $nSeparatorPos = strpos($sPropertyName, '.');
            if ($nSeparatorPos !== false) { $sPropertyName = substr($sPropertyName, 0, $nSeparatorPos); }
            
            
            if (!isset($this->_aPropertyTemplates[$sPropertyName]))
            {
                return "Aimless says: No template set for property '$sPropertyName'. Use AimlessComponent->setPropertyTemplate()";
                
                // 1. broadcast webevent for debugging purposes
                // 2. standaard report error (error level)
            }
            
            // render and send
            return $this->renderCollection($value, $this->_aPropertyTemplates[$sPropertyName]->template_name);
        }
        else
        {
            // format
            if (isset($this->_aPropertyFormatters[$sPropertyName]))
            {
                $fDelegate = $this->_aPropertyFormatters[$sPropertyName]->delegate;
                
                $value = $fDelegate($value);
            }
            
            // send
            return $value;
        }
    }
    
    public function collection($sCollectionName)
    {
        if (!isset($this->_aCollections[$sCollectionName]))
        {
            die("Aimless says: Collection '$sCollectionName' not found");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }
        
        // load
        $collection = $this->_aCollections[$sCollectionName];
        
        // render and send
        return $this->renderCollection($collection->collection, $collection->template_name);
    }
    
    public function realtime($sPropertyName = null)
    {
//        echo '<pre>';
//        print_r($this->_entity);
//        echo '</pre>';
        
        if (empty($this->_entity))
        {   
            die("Aimless says: Realtime feature for property '$sPropertyName' not possible if no entity is set");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }
        
        
        if ($sPropertyName === null)
        {
            return 'mls_id="'.$this->_entity->getAimlessId().'"';
        }
        else
        {
            return 'mls_value="'.$this->_entity->getAimlessValue($sPropertyName).'"';
        }
    }
    
    
    
    /**
     * Get entity's meta information 'id' or 'created'
     * @param type $sPropertyName The entity's meta information 'id' or 'created'
     * @return string
     */
    public function meta($sPropertyName)
    {
        switch(strtolower($sPropertyName))
        {
            case 'id': return $this->_entity->getId();
            case 'type': return $this->_entity->getEntityType();
            case 'created': return $this->_entity->getCreated();
        }
    }
    
    
    public function setupProperty()
    {
        
    }
    
    
    
    public function render()
    {
        // get te
        $sTemplateFile = $this->_AimlessService->getTemplate($this->_sTemplateName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;
        
        // output
        return $this->_TwigService->render($sTemplateFile, $this->_aVars);
    }
    
    
    
    private function renderCollection($aCollection, $sTemplateName)
    {
        // init
        $sRenderedCollection = '';
        
        for ($i = 0; $i < count($aCollection); $i++)
        {
            // register
            $entity = $aCollection[$i];
            
//            echo '<pre>';
//            echo 'Load property. En niet de referentie naar het item';
//            print_r($entity);
//            echo '</pre>';
//          
            
            // create
            $component = $this->_AimlessService->createComponent($sTemplateName, $entity);
            
            // forward
            foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }
            
            // output
            $sRenderedCollection .= $component->render();
        }
        
        // send
        return $sRenderedCollection;
    }
    
}
