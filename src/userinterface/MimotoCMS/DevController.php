<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;


/**
 * DevController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DevController
{
    
    public function viewNewInterface(Application $app)
    {
        return $app['twig']->render('MimotoCMS/components/base_dev.twig', array(
            'userName' => 'Sebastian Kersten!',
            'userAvatar' => 'link_to_image'
        ));
    }
    
}
