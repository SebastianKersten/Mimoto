<?php

// classpath
namespace Mimoto\Aimless;


use Mimoto\Data\MimotoEntity;
use Mimoto\Aimless\AimlessInputViewModel;


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
    public function __construct($sComponentName, $entity, $sFieldName, $value, $AimlessService, $DataService, $TwigService)
    {
        // forward
        parent::__construct($sComponentName, $entity, $AimlessService, $DataService, $TwigService);

        // store
        $this->_sFieldId = $sFieldName;
        $this->_value = $value;
    }

    public function input()
    {
        return 'mls_form_input="'.$this->_sFieldId.'" name="'.$this->_sFieldId.'"';
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

    public function fieldOptions()
    {
        // register
        $fieldValue = $this->_entity->getValue('value');

        // validate
        if (empty($fieldValue)) { $GLOBALS['Mimoto.Log']->notify('AimlessInput', "No 'value' set on iput field"); return; }

        // register
        $aFieldValueOptions = $fieldValue->getValue('options', true);

        // collect
        $aOptions = [];
        $nOptionCount = count($aFieldValueOptions);
        for ($i = 0; $i < $nOptionCount; $i++)
        {
            // register
            $fieldValueOption = $aFieldValueOptions[$i];

            // compose
            $option = (object) array(
                'key' => $fieldValueOption->getValue('key'),
                'value' => $fieldValueOption->getValue('value')
            );

            // store
            $aOptions[] = $option;
        }

        // send
        return $aOptions;
    }

    public function fieldValidation()
    {

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

        // create
        $viewModel = new AimlessInputViewModel($this);

        // compose
        $this->_aVars['Aimless'] = $viewModel;

        // render
        $sRenderedField = $this->_TwigService->render($sComponentFile, $this->_aVars);

        // connect
        $sRenderedField .= '<script>Mimoto.form.registerInputField("'.$this->_sFieldId.'")</script>';

        // output
        return $sRenderedField;
    }
    
}
