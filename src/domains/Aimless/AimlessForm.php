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
            $sAction = '/Mimoto.Aimless/form/'.$this->_sFormName;
            $sMethod = 'POST';
        }


        // prepare
        $jsonActions = (isset($this->_aOptions['response'])) ? json_encode($this->_aOptions['response']) : '{}';


        // 1. autosave (= also realtime collaboration)
        // 2. responseInstructions (connect, close popup, instruction editor on form)
        // 3. public key
        // 4. entity id


        // init
        $sRenderedForm = '<form data-mimoto-form="'.$form->getEntityTypeName().'.'.$form->getId().'" '.
            'data-mimoto-form-name=“'.$this->_sFormName.'" '.
            'data-mimoto-form-instance=“'.$formFieldValues->entityId.'" '.
            'data-mimoto-form-publickey="'.Mimoto::service('users')->getUserPublicKey(json_encode($formFieldValues)).'" '.
            'data-mimoto-form-actions="'.htmlentities(json_encode($jsonActions), ENT_QUOTES, 'UTF-8').'" '.
            'data-mimoto-form-autosave="true">';
            //$sRenderedForm = '<form name="'.$this->_sFormName.'">';// action="'.$sAction.'" method="'.$sMethod.'">';
//        $sRenderedForm .= '<script>Mimoto.utils.registerRequest(Mimoto.form.open, "'.$this->_sFormName.'", "'.$sAction.'", "'.$sMethod.'", '.($form->getValue('realtimeCollaborationMode') ? 'true' : 'false').', \''.$jsonResponseSettings.'\')</script>';


        // add security
        $sRenderedForm .= '<input type="hidden" name="Mimoto.EntityId" value="'.$formFieldValues->entityId.'">';

        // add instructions
        if (!empty($this->_aOptions) && !empty($this->_aOptions['onCreatedConnectTo']))
        {
            $sRenderedForm .= '<input type="hidden" name="Mimoto.onCreated:connectTo" value="'.$this->_aOptions['onCreatedConnectTo'].'">';
        }

        // render form
        $sRenderedForm .= parent::renderCollection($aFields, null, null, $formFieldValues->fields, true);

        // finish
        $sRenderedForm .= '</form>';
//        $sRenderedForm .= '<script>Mimoto.utils.registerRequest(Mimoto.form.close, "'.$this->_sFormName.'");</script>';

        // output
        return $sRenderedForm;
    }
}
