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

    // services
    private $_FormService;

    // data
    private $_xValues;



    /**
     * Constructor
     * @param string $sFormName
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param AimlessService $AimlessService
     * @param MimotoEntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sFormName, $xValues, $options, $AimlessService, $DataService, $FormService, $LogService, $TwigService)
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
        }
    }


    public function render()
    {
        // 1. load form
        $form = $this->_FormService->getFormByName($this->_sFormName);

        // 2. register fields
        $aFields = $form->getValue('fields', true);

        // 3. prepare
        $formVars = $this->_FormService->getFormVars($form, $this->_xValues, $aFields);

        // prepare
        $sAction = '/Mimoto.Aimless/form/'.$this->_sFormName; // #todo - replace with custom if present (expliciet by toggle)
        $sMethod = 'POST';

        // init
        $sRenderedForm = '<form name="'.$this->_sFormName.'" action="'.$sAction.'" method="'.$sMethod.'">';
        $sRenderedForm .= '<script>Mimoto.form.openForm("'.$this->_sFormName.'", "'.$sAction.'", "'.$sMethod.'")</script>';

        // add security
        $sRenderedForm .= '<input type="hidden" name="Mimoto.PublicKey" value="'.$GLOBALS['Mimoto.User']->getUserPublicKey(json_encode($formVars->connectedEntities)).'">';

        // render form
        $sRenderedForm .= parent::renderCollection($aFields, null, null, $formVars->fieldVars);

        // finish
        $sRenderedForm .= '</form>';
        $sRenderedForm .= '<script>Mimoto.form.closeForm("'.$this->_sFormName.'");</script>';

        // output
        return $sRenderedForm;
    }
}
