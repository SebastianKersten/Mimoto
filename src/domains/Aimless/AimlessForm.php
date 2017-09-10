<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Data\MimotoEntity;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;


/**
 * AimlessForm
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessForm extends AimlessComponent
{

    // services
    private $_FormService;

    // data
    private $_xValues;
    private $_aOptions;



    /**
     * Constructor
     * @param string $sFormName
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param OutputService $OutputService
     * @param DataService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sFormName, $entity, $aOptions, $OutputService, $DataService, $FormService, $LogService, $TwigService)
    {

        if (empty($options))
        {
            // register
            $this->_OutputService = $OutputService;
            $this->_DataService = $DataService;
            $this->_FormService = $FormService;
            $this->_LogService = $LogService;
            $this->_TwigService = $TwigService;

            // register
            $this->_sFormName = $sFormName;
            $this->_entity = $entity;
            $this->_aOptions = $aOptions;
        }
    }


    public function render($customValues = null)
    {
        // 1. load form
        $form = $this->_FormService->getFormByName($this->_sFormName, $this->_entity);

        // 2. register fields
        $aFields = $form->getValue('fields');

        // #fixme
        $nEntityId = ($this->_entity instanceof MimotoEntity) ? $this->_entity->getId() : null;

        // 3. prepare
        $formFieldValues = $this->_FormService->getFormFieldValues($form, $this->_entity, $aFields, $nEntityId);


        if ($form->getValue('customSubmit') === true)
        {
            $sAction = $form->getValue('action');
            $sMethod = $form->getValue('method');
        }
        else
        {
            // prepare
            $sAction = '/mimoto/form/'.$this->_sFormName;
            $sMethod = 'POST';
        }



        // 1. autosave (= also realtime collaboration)
        // 2. responseInstructions (connect, close popup, instruction editor on form)
        // 3. public key
        // 4. entity id


        $sFormActions = (!empty($this->_aOptions)) ? htmlentities(json_encode($this->_aOptions), ENT_QUOTES, 'UTF-8') : '';


        // init
        $sRenderedForm = '<form data-mimoto-form="'.$form->getEntityTypeName().'.'.$form->getId().'" '.
            'data-mimoto-form-name="'.$this->_sFormName.'" '.
            'data-mimoto-form-action="'.$sAction.'" '.
            'data-mimoto-form-method="'.$sMethod.'" '.
            'data-mimoto-form-instanceid="'.$formFieldValues->entityId.'" '.
            'data-mimoto-form-publickey="'.Mimoto::service('users')->getUserPublicKey(json_encode($formFieldValues)).'" '.
            'data-mimoto-form-actions="'.$sFormActions.'" '.
            'data-mimoto-form-manualsave="'.(($form->get('manualSave') == 1) ? 'true' : 'false').'">';

        // render form
        $sRenderedForm .= parent::renderCollection($aFields, null, null, $formFieldValues->fields, true);

        // finish
        $sRenderedForm .= '</form>';

        // output
        return $sRenderedForm;
    }
}
