<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * AimlessComponent
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponent
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
     * @param string $sTemplateName
     * @param MimotoEntity $entity
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
    
    public function setPropertyTemplate($sKey, $sTemplateName)
    {
        $propertyTemplate = (object) array(
            'sTemplateName' => $sTemplateName
        );
        
        $this->_aPropertyTemplates[$sKey] = $propertyTemplate;
    }
    
    
    public function setPropertyFormatter($sKey, $fDelegate)
    {
        $propertyFormatter = (object) array(
            'delegate' => $fDelegate
        );
        
        $this->_aPropertyFormatters[$sKey] = $propertyFormatter;
    }
    
    public function setVar($sKey, $value)
    {
        // register
        $this->_aVars[$sKey] = $value;
    }
    
    public function addSelection($sKey, $sTemplateName, $aSelection)
    {
        $this->_aSelections[$sKey] = (object) array(
            'sTemplateName' => $sTemplateName,
            'selection' => $aSelection
        );
    }

    public function addForm($sFormName, $aValues, $sKey = null)
    {
        // default
        if ($sKey === null) $sKey = self::PRIMARY_FORM;

        // store
        $this->_aFormConfigs[$sKey] = (object) array(
            'sFormName' => $sFormName,
            'aValues' => $aValues
        );
    }





    // --- Twig usage


    public function data($sPropertyName)
    {
        // validate
        if (empty($this->_entity)) return;



        // 1. subpropertyname (selector-query)



        // read
        $value = $this->_entity->getValue($sPropertyName, true);
        
        
        // verify
        if (is_array($value))
        {
            
            //echo '######';
            
            
            // 5. MimotoData check if collection item already loaded
            
            //echo '<pre>';
            //print_r($value);
            //echo '</pre>';
            
            
            $nSeparatorPos = strpos($sPropertyName, '.');
            if ($nSeparatorPos !== false) { $sPropertyName = substr($sPropertyName, 0, $nSeparatorPos); }
            
            
            if (!isset($this->_aPropertyTemplates[$sPropertyName]))
            {
                return "Aimless says: No template set for property '$sPropertyName'. Use AimlessComponent->setPropertyTemplate()";
                
                // 1. broadcast webevent for debugging purposes
                // 2. standaard report error (error level)
            }
            
            // render and send
            return $this->renderCollection($value, $this->_aPropertyTemplates[$sPropertyName]->sTemplateName);
        }
        else
        {
            // format
            if (isset($this->_aPropertyFormatters[$sPropertyName]))
            {
                $fDelegate = $this->_aPropertyFormatters[$sPropertyName]->delegate;
                
                $value = $fDelegate($value);
            }
            
            //if (isset($this->_aPropertyTemplates[$sPropertyName]))
            //{
                
                // 1. check if is entity instanceof MimotoEntity
                // 2. wrap in template
                
                
                // get te
            //    $sTemplateFile = $this->_AimlessService->getTemplate($this->_sTemplateName, $this->_entity);
                
            //}
            //else
            //{
                // send
                return $value;
            //}
        }
    }
    
    public function selection($sSelectionName)
    {
        // validate
        if (!isset($this->_aSelections[$sSelectionName])) die("Aimless says: Selection '$sSelectionName' not defined");
        
        // load
        $selection = $this->_aSelections[$sSelectionName];
        
        // render and send
        return $this->renderCollection($selection->selection, $selection->sTemplateName);
    }

    public function form($sKey = null)
    {
        // 1. createForm and return (pass form to new component



        // 1. set default key
        if ($sKey === null) $sKey = self::PRIMARY_FORM;

        // 2. validate is form was defined
        if (!isset($this->_aFormConfigs[$sKey])) die("Aimless says: Form '$sKey' not defined");

        // 3. load requested config
        $formConfig = $this->_aFormConfigs[$sKey];

        // 4. load form from database
        $aResults = $this->_DataService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $formConfig->sFormName]]);

        // 5. validate if form exists
        if (!isset($aResults[0])) die("Aimless says: Form with name '$formConfig->sFormName' not found in database");

        // 6. render and send
        return $this->renderForm($aResults[0], $formConfig->aValues);
    }

    public function realtime($sPropertySelector = null)
    {
        // validate
        if (empty($this->_entity)) return;


        if ($sPropertySelector !== null)
        {
            // cleanup
            $nSeparatorPos = strpos($sPropertySelector, '.');
            $sPropertyName = ($nSeparatorPos !== false) ? substr($sPropertySelector, 0, $nSeparatorPos) :  $sPropertySelector;
            
            $sSubpropertySelector = substr($sPropertySelector, $nSeparatorPos + 1);
            $aConditionals = MimotoDataUtils::getConditionals($sSubpropertySelector);
            
            // compose
            $sFilter = (!empty($aConditionals)) ? " mls_filter='".json_encode($aConditionals)."'" : '';
            
            
            if (!empty($this->_entity) && $this->_entity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {
                // compose
                $sTemplate = (!empty($this->_aPropertyTemplates[$sPropertyName]->sTemplateName)) ? " mls_template='".$this->_aPropertyTemplates[$sPropertyName]->sTemplateName."'" : '';

                // send
                return "mls_contains='".$this->_entity->getAimlessValue($sPropertyName)."'".$sFilter.$sTemplate;
            }
            else
            if (isset($this->_aSelections[$sPropertyName]))
            {
                // compose
                $sTemplate = " mls_template='".$this->_aSelections[$sPropertyName]->sTemplateName."'";

                // send
                return "mls_contains='".$this->_aSelections[$sPropertyName]->selection->getCriteria()['type']."'".$sFilter.$sTemplate;
            }
                
        }
        
        
        if (empty($this->_entity))
        {
            die("Aimless says: Realtime feature for property '$sPropertySelector' not possible if no entity is set");
        
            // 1. broadcast webevent for debugging purposes
            // 2. standaard report error (error level)
        }
            
            
        if ($sPropertySelector === null)
        {
            return "mls_id='".$this->_entity->getAimlessId()."'";
        }
        else
        {
            return "mls_value='".$this->_entity->getAimlessValue($sPropertySelector)."'";
        }
    }
    
    
    
    /**
     * Get entity's meta information 'id' or 'created'
     * @param type $sPropertyName The entity's meta information 'id' or 'created'
     * @return string
     */
    public function meta($sPropertyName)
    {
        // validate
        if (empty($this->_entity)) return;


        switch(strtolower($sPropertyName))
        {
            case 'id': return $this->_entity->getId();
            case 'type': return $this->_entity->getEntityType();
            case 'group': return $this->_entity->getEntityGroup();
            case 'created': return $this->_entity->getCreated();
        }
    }
    
    
    public function setupProperty()
    {
        // connect Entity-template to entity
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

// #todo - Verplaats naar AimlessForm
    private function renderForm($form, $aValues)
    {
        // init
        $sRenderedForm = '<form>';
        $sRenderedForm .= '<script>Mimoto.form.registerForm("'.$form->getValue('name').'", "/mimoto.cms/entity/1/update", "POST");</script>';

        // load
        $aFields = $form->getValue('fields', true);

        //output('fields', $aFields);

        for ($i = 0; $i < count($aFields); $i++)
        {
            // register
            $fieldData = $aFields[$i];

            // read
            $sTemplateName = $fieldData->getEntityType();

            // create
            switch($fieldData->getEntityGroup())
            {
                case CoreConfig::GROUP_MIMOTO_FORM_INPUT:

                     $value = (isset($aValues[$fieldData->getValue('varname')])) ? $aValues[$fieldData->getValue('varname')] : '';

                    $formFieldComponent = $this->_AimlessService->createInput($sTemplateName, $fieldData, $value);
                    break;

                default:

                    $formFieldComponent = $this->_AimlessService->createComponent($sTemplateName, $fieldData);
                    break;
            }

            // forward
            foreach ($this->_aVars as $sKey => $value) { $formFieldComponent->setVar($sKey, $value); }

            // output
            $sRenderedForm .= $formFieldComponent->render();


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
        }

        // finish
        $sRenderedForm .= '</form>';

        // send
        return $sRenderedForm;
    }
    
}
