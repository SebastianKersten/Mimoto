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



    private $_xData;



    /**
     * Constructor
     * @param string $sFormName
     * @param string $sComponentName
     * @param MimotoEntity $entity
     * @param AimlessService $AimlessService
     * @param MimotoEntityService $DataService
     * @param Twig $TwigService
     */
    public function __construct($sFormName, $xData, $sFormLayout, $entity, $sComponentName, $AimlessService, $DataService, $TwigService)
    {
        // forward
        parent::__construct($sFormLayout, null, $AimlessService, $DataService, $TwigService);


        // 1. store form

        $this->addForm($sFormName, $sComponentName, $sKey = null);

        // register
        $this->_sFormName = $sFormName;
        $this->_sComponentName = $sComponentName;
        $this->_xData = $xData;


        // 1. auto render if no template set (verplaats naar AimlessComponent
    }
}
