<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
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
    public function __construct($sComponentName, $entity, $connection, $sFieldName, $value, $AimlessService, $DataService, $LogService, $TwigService)
    {
        // forward
        parent::__construct($sComponentName, $entity, $connection, null, $AimlessService, $DataService, $LogService, $TwigService);

        // store
        $this->_sFieldId = $sFieldName;
        $this->_value = $value;
    }

    public function field()
    {
        return 'data-aimless-form-field="'.$this->_sFieldId.'"';
    }

    public function input()
    {
        return 'data-aimless-form-field-input="'.$this->_sFieldId.'" name="'.$this->_sFieldId.'"';
    }

    public function fieldId()
    {
        return $this->_sFieldId;
    }

    public function error()
    {
        return 'data-aimless-form-field-error="'.$this->_sFieldId.'"';
    }

    public function value($bRenderValues = false, $sModuleName = null, $mapping = null, $customVars = null)
    {
        // return raw value (= connection)
        if (!$bRenderValues)
        {
            if (is_array($this->_value))
            {
                // convert and send
                return json_encode($this->_value);
            }
            else
            {
                // send
                return $this->_value;
            }
        }

        if (!is_array($this->_value))
        {
            // entity render

            return 'Entity #todo';
        }
        else
        {
            // collection render

            if (empty($sModuleName))
            {
                return 'Please supply a module name when rendering a list value';
            }
            else
            {
                // init
                $sOutput = '';

                $nItemCount = count($this->_value);
                for ($nItemIndex = 0; $nItemIndex < $nItemCount; $nItemIndex++)
                {
                    // split
                    $aSelectorComponents = explode('.', $this->_value[$nItemIndex]);

                    // register
                    $nEntityTypeName = $aSelectorComponents[0];
                    $nEntityId = $aSelectorComponents[1];

                    // read
                    $entity = Mimoto::service('data')->get($nEntityTypeName, $nEntityId);

                    // create
                    $component = Mimoto::service('aimless')->createComponent($sModuleName, $entity);

                    // configure
                    if (!empty($mapping)) $component->setMapping($mapping);

                    // render
                    $sOutput .= $component->render($customVars);
                }

                return $sOutput;
            }
        }
    }


// #todo - support diffs
//    public function realtime($sPropertySelector = null)
//    {
//
//    }
    
    
    public function render($customValues = null)
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
            'validation' => $this->getFieldValidationRules()
        );


        // 1. add type
        // 2. add field id (niet van entity maar van eigenlijk formfield
        // 3. derde parameter

        // connect
        $sRenderedField .= '<script>Mimoto.Aimless.utils.registerRequest(Mimoto.form.registerInputField, "'.$this->_sFieldId.'", '.json_encode($settings).')</script>';

        // output
        return $sRenderedField;
    }

    /**
     * Get field validation rules
     * @return array Validation rules
     */
    private function getFieldValidationRules()
    {
        // init
        $aValidationRules = [];

        // read
        $aValueValidationRules = $this->_entity->getValue('validation');

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
                    'type' => $validationRule->getValue('type'),
                    'value' => $validationRule->getValue('value'),
                    'errorMessage' => $validationRule->getValue('errorMessage'),
                    'trigger' => $validationRule->getValue('trigger')
                );
            }
        }

        // send
        return $aValidationRules;
    }

}
