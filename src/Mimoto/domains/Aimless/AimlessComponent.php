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
    
    
    var $_sTemplateName;
    
    
    var $_aVars = [];
    
    
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
    
    
    // --- Twig usage
    
    public function data($sPropertyName)
    {
        return $this->_entity->getValue($sPropertyName);
    }
    
    public function live($sPropertyName = null)
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
            case 'created': return $this->_entity->getCreated();
        }
    }
    
    
    public function setupProperty()
    {
        
    }
    
    
    
    public function render()
    {
        
        // get te
        $sTemplate = $this->_AimlessService->getTemplate($this->_sTemplateName);
        
        // compose
        $this->_aVars['Aimless'] = $this;
        
        // output
        return $this->_TwigService->render($sTemplate, $this->_aVars);
    }
}
