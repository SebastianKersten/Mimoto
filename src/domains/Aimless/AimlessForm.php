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
    public function __construct($sFormName, $xValues, $options, $AimlessService, $DataService, $TwigService)
    {

        if (empty($options))
        {
            // register
            $this->_AimlessService = $AimlessService;
            $this->_DataService = $DataService;
            $this->_TwigService = $TwigService;

            // register
            $this->_sFormName = $sFormName;
            $this->_xValues = $xValues;
        }
    }


    public function render()
    {
        // 1. load form from database
        $aResults = $this->_DataService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $this->_sFormName]]);

        // 2. validate if form exists
        if (!isset($aResults[0])) error("Aimless says: Form with name '".$this->_sFormName."' not found in database");


        $form = $aResults[0];
        $aFields = $form->getValue('fields', true);


        // prepare
        $sAction = '/Mimoto.Aimless/form/'.$this->_sFormName;
        $sMethod = 'POST';

        // init
        $sRenderedForm = '<form name="'.$this->_sFormName.'" action="'.$sAction.'" method="'.$sMethod.'">';
        $sRenderedForm .= '<script>Mimoto.form.openForm("'.$this->_sFormName.'", "'.$sAction.'", "'.$sMethod.'")</script>';

        // render form
        $sRenderedForm .= parent::renderCollection($aFields, null, null, $this->_xValues);

        // finish
        $sRenderedForm .= '</form>';
        $sRenderedForm .= '<script>Mimoto.form.closeForm("'.$this->_sFormName.'");</script>';

        // output
        return $sRenderedForm;
    }
}
