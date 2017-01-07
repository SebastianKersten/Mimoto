<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Aimless\AimlessComponent;


class InterfaceUtils
{

    public static function addMenuToComponent(AimlessComponent $component)
    {
        // load
        $aMenuContentSections = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION]);

        // setup
        $component->addSelection('menuContentSections', $aMenuContentSections);

        // send
        return $component;
    }


    //public function setService()
}
