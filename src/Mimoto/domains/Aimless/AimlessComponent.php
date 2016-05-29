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
    
    
    public function setValueFormatter()
    {
    }
    
    public function setVar($sKey, $value)
    {
        // register
        $this->_aVars[$sKey] = $value;
    }
    
    public function setCollection($sKey, $sTemplateName, $aCollection)
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
        return $this->_entity->getValue($sPropertyName);
    }
    
    public function collection($sCollectionName)
    {
        if (!isset($this->_aCollections[$sCollectionName]))
        {
            die("MimotoAimlessService says: Template '$sTemplateName' not found");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }
        
        
        $collection = $this->_aCollections[$sCollectionName];
        
        
        $sRenderedCollection = '';
        
        for ($i = 0; $i < count($collection->collection); $i++)
        {
            // register
            $entity = $collection->collection[$i];
            
            // create
            $component = $this->_AimlessService->createComponent($collection->template_name, $entity);
            
            // forward
            foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }
            
            // output
            $sRenderedCollection .= $component->render();
        }
        
        return $sRenderedCollection;
    }
    
    public function realtime($sPropertyName = null)
    {
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
}
