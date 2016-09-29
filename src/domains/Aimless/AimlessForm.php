<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * AimlessForm
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessForm extends AimlessComponent
{
    
    /**
     * Constructor
     * @param string $sFormName
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param AimlessService $AimlessService
     * @param MimotoEntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sFormName, $data, $sFormLayout, $sComponentName, $AimlessService, $DataService, $TwigService)
    {
        // forward
        parent::__construct($sFormLayout, null, $AimlessService, $DataService, $TwigService);



        // param 1 - form name
        // param 2 - data (array/object of single)
        // param 3 - component name (voorzien van conditionals) (default = default theme)
        // param 4 - form template/component (default = empty template)


        // action 1 - store in aForms array
        // action 2 - onRender -> render all forms


        // note 1 - add form to component -> is gelijk aan AimlessForm aanmaken



        // register
        $this->_sFormName = $sFormName;
        $this->_sComponentName = $sComponentName;
        $this->_entity = $entity;


        $this->addForm($sFormName, $sComponentName, $sKey = null);

        
        // register
        $this->_AimlessService = $AimlessService;
        $this->_DataService = $DataService;
        $this->_TwigService = $TwigService;
    }


    public function submit($sKey = null)
    {
        // 1. set default key
        if ($sKey === null) $sKey = self::PRIMARY_FORM;

        // 2. validate is form was defined
        if (!isset($this->_aFormConfigs[$sKey])) die("Aimless says: Form '$sKey' not defined");

        // 3. load requested config
        $formConfig = $this->_aFormConfigs[$sKey];

        return 'mls_form_submit="'.$formConfig->sFormName.'"';
    }

    public function form($sKey = null)
    {
        // 1. createForm and return (pass form to new component

        error($this->_aFormConfigs);

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
    
    
    public function render()
    {
        // get te
        $sComponentFile = $this->_AimlessService->getComponentFile($this->_sComponentName, $this->_entity);
        
        // compose
        $this->_aVars['Aimless'] = $this;
        
        // output
        return $this->_TwigService->render($sComponentFile, $this->_aVars);



        // init
        $sRenderedForm = '<form>';

        // load
        $aFields = $form->getValue('fields', true);

        //output('fields', $aFields);

        $nFieldCount = count($aFields);
        for ($i = 0; $i < $nFieldCount; $i++)
        {
            // register
            $field = $aFields[$i];

            // read
            $sTemplateName = $field->getEntityTypeName();

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
    
    
    
    private function renderCollection($aCollection, $sTemplateName)
    {
        // init
        $sRenderedCollection = '';

        $nCollectionCount = count($aCollection);
        for ($i = 0; $i < $nCollectionCount; $i++)
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

    }
    
}
