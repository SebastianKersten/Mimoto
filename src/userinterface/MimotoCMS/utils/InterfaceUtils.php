<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS\utils;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
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

}
