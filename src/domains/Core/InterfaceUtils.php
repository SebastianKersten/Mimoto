<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Aimless\AimlessComponent;


class InterfaceUtils
{

    public static function addMenuToComponent(AimlessComponent $component)
    {
        // load
        $aMenuContentSections = $GLOBALS['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION]);

        // setup
        $component->addSelection('menuContentSections', $aMenuContentSections);

        // send
        return $component;
    }


    //public function setService()
}
