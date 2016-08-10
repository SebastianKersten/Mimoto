<?php

// classpath
namespace Mimoto\Aimless;


/**
 * AimlessForm
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessForm
{
    
    // services
    var $_AimlessService;
    var $_TwigService;
    
    // data
    var $_entity;
    
    // settings
    var $_sFormName;
    
    // config
    var $_aVars = [];
    var $_aSelections = [];
    var $_aPropertyTemplates = [];
    var $_aPropertyFormatters = [];
    
    
    
    /**
     * Constructor
     * @param type $sViewmodelName
     * @param type $entity
     */
    public function __construct($sFormName, $entity, $AimlessService, $TwigService)
    {

        parent::__construct($sFormName, $entity, $AimlessService, $TwigService);

        // register
        $this->_sFormName = $sFormName;
        $this->_entity = $entity;

        // register
        $this->_AimlessService = $AimlessService;
        $this->_TwigService = $TwigService;
    }

//    input
//    field
//    value
//    error


//<!-- auto include by AimlessForm ( #TODO - include form id for auto connect and reading of values directly from field form.submit() -->
//<script>Mimoto.form.registerInputField('{{ name }}'{% if validation is not empty %}, {{ validation|raw }}{% endif %})</script>
//settings blind toevoegen aan register
//settings toevoegen aan properties




    
    
    public function render()
    {
        // get form
        $sTemplateFile = $this->_AimlessService->getComponent($this->_sFormName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;
        
        // output
        return $this->_TwigService->render($sTemplateFile, $this->_aVars);
    }
    
}
