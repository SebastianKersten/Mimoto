<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\AimlessComponent;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * AimlessForm
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessForm extends AimlessComponent
{
    
    // services
    var $_AimlessService;
    var $_DataService;
    var $_TwigService;
    
    // data
    var $_entity;
    
    // settings
    var $_sTemplateName;
    
    // config
    var $_aVars = [];
    var $_aSelections = [];
    var $_aFormConfigs = [];
    var $_aPropertyTemplates = [];
    var $_aPropertyFormatters = [];

    const PRIMARY_FORM = 'primary_form';

    
    /**
     * Constructor
     * @param type $sViewmodelName
     * @param type $entity
     */
    public function __construct($sTemplateName, $entity, $AimlessService, $DataService, $TwigService)
    {
        // register
        $this->_sTemplateName = $sTemplateName;
        $this->_entity = $entity;
        
        // register
        $this->_AimlessService = $AimlessService;
        $this->_DataService = $DataService;
        $this->_TwigService = $TwigService;
    }

    public function submit()
    {
        return 'mls_form_submit='.'';
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


    private function renderForm($form, $aValues)
    {
        // init
        $sRenderedForm = '<form>';

        // load
        $aFields = $form->getValue('fields', true);

        //output('fields', $aFields);

        for ($i = 0; $i < count($aFields); $i++)
        {
            // register
            $field = $aFields[$i];

            // read
            $sTemplateName = $field->getEntityType();

            // create
            $component = $this->_AimlessService->createComponent($sTemplateName, $field);

            // forward
            foreach ($this->_aVars as $sKey => $value) { $component->setVar($sKey, $value); }

            // output
            $sRenderedForm .= $component->render();


            // 1. settings pass blindly: {% if validation is not empty %}, {{ validation|raw }}{% endif %}
            // 2. hoe validation opslaan? single pass van alle fields? of validation entity table

            // 3. form name / field is unique field-id
            // 4. hoe koppelen aan values?

            // 5. add action to form, retrieved from form-loaded from database
            // 6. add auto-register to each field



//            <script>Mimoto.form.registerInputField('{{ name }}'{% if validation is not empty %}, {{ validation|raw }}{% endif %})</script>
//
//            een field heeft settings:
//
//            _mimoto_inputfield
//            _mimoto_inputfieldsetting


            if ($field->getEntityGroup() == CoreConfig::GROUP_MIMOTO_FORM_INPUT)
            {
                $sRenderedForm .= '<script>Mimoto.form.registerInputField("'.$field->getId().'")</script>';
            }
        }

        // finish
        $sRenderedForm .= '</form>';

        // send
        return $sRenderedForm;
    }
    
}
