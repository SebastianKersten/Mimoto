<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;
use Mimoto\Aimless\AimlessInputViewModel;
use Mimoto\Selection\Selection;


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
    public function __construct($sComponentName, $entity, $connection, $sFieldName, $value, $nItemIndex = null, $OutputService, $DataService, $LogService, $TwigService)
    {
        // forward
        parent::__construct($sComponentName, $entity, $connection, null, $nItemIndex, $OutputService, $DataService, $LogService, $TwigService);

        // store
        $this->_sFieldId = $sFieldName;
        $this->_value = $value;
    }

    public function field()
    {
        return 'data-mimoto-form-field="'.$this->_sFieldId.'"';
    }

    public function input()
    {
        // init
        $sFormattingOptions = '';

        // split
        $aPropertySelectorElements = explode('.', $this->_sFieldId);


        // ---


        // load
        $aEntities = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_ENTITY, 'values' => ['name' => $aPropertySelectorElements[0]]]);

        // validate
        if (count($aEntities) == 1)
        {
            // register
            $eEntity = $aEntities[0];

            // read
            $aProperties = $eEntity->get('properties');

            // find
            $nPropertyCount = count($aProperties);
            for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
            {
                // register
                $eProperty = $aProperties[$nPropertyIndex];

                // verify
                if ($eProperty->get('name') == $aPropertySelectorElements[2])
                {
                    // read
                    $aSettings = $eProperty->get('settings');

                    // find
                    $nSettingCount = count($aSettings);
                    for ($nSettingIndex = 0; $nSettingIndex < $nSettingCount; $nSettingIndex++)
                    {
                        // register
                        $eSetting = $aSettings[$nSettingIndex];

                        // verify
                        if ($eSetting->get('key') == EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS)
                        {
                            // read
                            $aFormattingOptions = $eSetting->get('formattingOptions');

                            // verify
                            if (count($aFormattingOptions) > 0)
                            {
                                // init
                                $formattingOptions = (object) array(
                                    'toolbar' => [],
                                    'formats' => []
                                );

                                // find
                                $nFormattingOptionCount = count($aFormattingOptions);
                                for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
                                {
                                    // register
                                    $eFormattingOption = $aFormattingOptions[$nFormattingOptionIndex];

                                    // register
                                    $formattingOptions->toolbar[] = $eFormattingOption->get('name');
                                    $formattingOptions->formats[] = $eFormattingOption->get('name');


//                                    ['bold', 'italic', 'underline', 'strike'],
//                                    ['blockquote', 'code-block', 'link'],
//                                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
//                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
//                                    [{ 'indent': '-1'}, { 'indent': '+1' }],

//                                    formats: ['bold', 'italic', 'underline', 'strike', 'blockquote', 'code-block', 'link', 'header', 'list', 'indent']
                                }

                                // convert
                                $sFormattingOptions = ' data-mimoto-input-formattingoptions="'.htmlentities(json_encode($formattingOptions), ENT_QUOTES, 'UTF-8').'"';
                            }
                            break;
                        }
                    }
                }
            }
        }

        // compose and send
        return 'data-mimoto-form-field-input="'.$this->_sFieldId.'" name="'.$this->_sFieldId.'"'.$sFormattingOptions;
    }

    public function fieldId()
    {
        return $this->_sFieldId;
    }

    public function error()
    {
        return 'data-mimoto-form-field-error="'.$this->_sFieldId.'"';
    }

    public function value($bRenderValues = false, $sModuleName = null, $mapping = null, $customVars = null)
    {
        // return raw value (= connection)
        if (!$bRenderValues)
        {
            if (!empty($this->_entity) && $this->_entity->getEntityTypeName() == CoreConfig::MIMOTO_FORM_INPUT_LIST)
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

            return '########### Entity #todo';
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


                // split
                $aEntitySelectorElements = explode('.', $this->_sFieldId);

                // validate
                if (!MimotoDataUtils::isValidId($aEntitySelectorElements[1])) return '';


                // load
                $eParent = Mimoto::service('data')->get($aEntitySelectorElements[0], $aEntitySelectorElements[1]);

                // register
                $aConnections = $eParent->getValue($aEntitySelectorElements[2], true);

                // parse items
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
                    $component = Mimoto::service('output')->createComponent($sModuleName, $entity, $aConnections[$nItemIndex]);

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
        $sComponentFile = $this->_OutputService->getComponentFile($this->_sComponentName, $this->_entity);

        // create
        $viewModel = new AimlessInputViewModel($this);

        // compose
        $this->_aVars['Mimoto'] = $viewModel;

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
        $sRenderedField .= '<script>MimotoX.utils.registerRequest(Mimoto.form.registerInputField, "'.$this->_sFieldId.'", '.json_encode($settings).')</script>';

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
