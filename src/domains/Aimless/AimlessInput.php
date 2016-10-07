<?php

// classpath
namespace Mimoto\Aimless;
use Mimoto\Data\MimotoEntity;


/**
 * AimlessInput
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessInput extends AimlessComponent
{

    // config
    private $_value;
    private $_sFieldId;

    
    /**
     * Constructor
     * @param string $sTemplateName
     * @param MimotoEntity $entity
     * @param mixed $value
     */
    public function __construct($sComponentName, $entity, $xValues, $AimlessService, $DataService, $TwigService)
    {
        // forward
        parent::__construct($sComponentName, $entity, $AimlessService, $DataService, $TwigService);


        // default
        $this->_sFieldId = '';
        $this->_value = '';


        $field = $entity->getValue('value');

        if (!empty($field))
        {

            if (!empty($field->getValue('varname')))
            {
                $this->_sFieldId = $field->getValue('varname');

                if ($xValues instanceof MimotoEntity)
                {
                    $this->_value = $xValues->getValue($this->_sFieldId);
                }
            }
        }

    }

    public function input()
    {
        return 'mls_form_input="'.$this->_sFieldId.'"';
    }

    public function field()
    {
        return 'mls_form_field="'.$this->_sFieldId.'"';
    }

    public function error()
    {
        return 'mls_form_error="'.$this->_sFieldId.'"';
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
        // get requested component
        $sComponentFile = $this->_AimlessService->getComponentFile($this->_sComponentName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;

        // render
        $sRenderedField = $this->_TwigService->render($sComponentFile, $this->_aVars);

        // connect
        $sRenderedField .= '<script>Mimoto.form.registerInputField("'.$this->_sFieldId.'")</script>';

        // output
        return $sRenderedField;
    }
    
}
