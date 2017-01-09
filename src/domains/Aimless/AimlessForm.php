<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
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
    public function __construct($sFormName, $xValues, $aOptions, $AimlessService, $DataService, $FormService, $LogService, $TwigService)
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
            $this->_xValues = $xValues;
            $this->_aOptions = $aOptions;
        }
    }


    public function render()
    {
        // 1. load form
        $form = $this->_FormService->getFormByName($this->_sFormName);

        // 2. register fields
        $aFields = $form->getValue('fields');

        // 3. prepare
        $formVars = $this->_FormService->getFormVars($form, $this->_xValues, $aFields);


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


        // init
        $sRenderedForm = '<form name="'.$this->_sFormName.'" action="'.$sAction.'" method="'.$sMethod.'">';
        $sRenderedForm .= '<script>Mimoto.form.open("'.$this->_sFormName.'", "'.$sAction.'", "'.$sMethod.'", '.($form->getValue('realtimeCollaborationMode') ? 'true' : 'false').')</script>';

        // add security
        $sRenderedForm .= '<input type="hidden" name="Mimoto.PublicKey" value="'.Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities)).'">';

        // add instructions
        if (!empty($this->_aOptions) && !empty($this->_aOptions['onCreatedConnectTo']))
        {
            $sRenderedForm .= '<input type="hidden" name="Mimoto.onCreated:connectTo" value="'.$this->_aOptions['onCreatedConnectTo'].'">';
        }

        // render form
        $sRenderedForm .= parent::renderCollection($aFields, null, null, $formVars->fieldVars, true);

        // finish
        $sRenderedForm .= '</form>';
        $sRenderedForm .= '<script>Mimoto.form.close("'.$this->_sFormName.'");</script>';

        // output
        return $sRenderedForm;
    }
}
