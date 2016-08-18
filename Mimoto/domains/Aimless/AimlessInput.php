<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\AimlessComponent;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * AimlessInput
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessInput extends AimlessComponent
{

    // config
    var $_value;
    var $_sVarName;

    
    /**
     * Constructor
     * @param string $sTemplateName
     * @param MimotoEntity $entity
     * @param mixed $value
     */
    public function __construct($sTemplateName, $entity, $value, $AimlessService, $DataService, $TwigService)
    {
        // forward
        parent::__construct($sTemplateName, $entity, $AimlessService, $DataService, $TwigService);

        // register
        $this->_value = $value;
        $this->_sVarName = $entity->getValue('varname');
    }


    public function field()
    {
        return 'mls_form_field="'.$this->_sVarName.'"';
    }

    public function error()
    {
        return 'mls_form_error="'.$this->_sVarName.'"';
    }

    public function value()
    {
        return $this->_value;
    }


// #todo - support diffs
//    public function realtime($sPropertySelector = null)
//    {
//
//    }
    
    
    public function render()
    {
        // get requested template
        $sTemplateFile = $this->_AimlessService->getTemplate($this->_sTemplateName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;

        // render
        $sRenderedField = $this->_TwigService->render($sTemplateFile, $this->_aVars);

        // connect
        $sRenderedField .= '<script>Mimoto.form.registerInputField("'.$this->_sVarName.'")</script>';

        // output
        return $sRenderedField;
    }
    
}
