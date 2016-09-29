<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;


/**
 * NotificationCenterController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class NotificationCenterController
{
    
    public function viewNotificationCenter(Application $app)
    {
        // load
        $aNotifications = $app['Mimoto.Data']->find('notification');
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('notificationcenter');
        
        // setup
        $component->addCollection('notifications', 'notification', $aNotifications);
        
        // render and send
        return $component->render();
    }
    
}
