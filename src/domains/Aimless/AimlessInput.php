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
    public function __construct($sComponentName, $entity, $sFieldName, $value, $AimlessService, $DataService, $LogService, $TwigService)
    {
        // forward
        parent::__construct($sComponentName, $entity, $AimlessService, $DataService, $LogService, $TwigService);

        // store
        $this->_sFieldId = $sFieldName;
        $this->_value = $value;
    }

    public function field()
    {
        return 'mls_form_field="'.$this->_sFieldId.'"';
    }

    public function input()
    {
        return 'mls_form_field_input="'.$this->_sFieldId.'" name="'.$this->_sFieldId.'"';
    }

    public function error()
    {
        return 'mls_form_field_error="'.$this->_sFieldId.'"';
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

        // load and prepare
        $settings = (object) array(
            'validation' => $this->getValidationRules()
        );

        // connect
        $sRenderedField .= '<script>Mimoto.form.registerInputField(\''.$this->_sFieldId.'\', '.json_encode($settings).')</script>';

        // output
        return $sRenderedField;
    }

    /**
     * Get validation rules
     * @return array Validation rules
     */
    private function getValidationRules()
    {
        // init
        $aValidationRules = [];

        // read
        $value = $this->_entity->getValue('value');
        $aValueValidationRules = $value->getValue('validation', true);

        // validate
        if (!empty($aValueValidationRules))
        {
            // load
            $nValidationCount = count($aValueValidationRules);
            for ($i = 0; $i < $nValidationCount; $i++)
            {
                // register
                $validationRule = $aValueValidationRules[$i];

                $aValidationRules[] = (object) array(
                    'key' => $validationRule->getValue('key'),
                    'value' => $validationRule->getValue('value'),
                    'errorMessage' => $validationRule->getValue('errorMessage')
                );
            }
        }

        // send
        return $aValidationRules;
    }
}
