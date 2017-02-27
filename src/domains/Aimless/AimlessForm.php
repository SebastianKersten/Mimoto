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
     * @param AimlessService $AimlessService
     * @param EntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sFormName, $entity, $aOptions, $AimlessService, $DataService, $FormService, $LogService, $TwigService)
    {

        if (empty($options))
        {
            // register
            $this->_AimlessService = $AimlessService;
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
        $form = $this->_FormService->getFormByName($this->_sFormName);

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
        $jsonResponseSettings = (isset($this->_aOptions['response'])) ? json_encode($this->_aOptions['response']) : '{}';


        // init
        $sRenderedForm = '<form name="'.$this->_sFormName.'">';// action="'.$sAction.'" method="'.$sMethod.'">';
        $sRenderedForm .= '<script>Mimoto.Aimless.utils.registerRequest(Mimoto.form.open, "'.$this->_sFormName.'", "'.$sAction.'", "'.$sMethod.'", '.($form->getValue('realtimeCollaborationMode') ? 'true' : 'false').', \''.$jsonResponseSettings.'\')</script>';



        // add security
        $sRenderedForm .= '<input type="hidden" name="Mimoto.PublicKey" value="'.Mimoto::service('users')->getUserPublicKey(json_encode($formFieldValues)).'">';
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
        $sRenderedForm .= '<script>Mimoto.Aimless.utils.registerRequest(Mimoto.form.close, "'.$this->_sFormName.'");</script>';

        // output
        return $sRenderedForm;
    }
}
