<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;


/**
 * NotificationsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class NotificationsController
{
    
    public function viewNotificationCenter(Application $app)
    {
        // load
        $aNotifications = $app['Mimoto.Data']->find([ 'type' => CoreConfig::MIMOTO_NOTIFICATION, 'value' => ['state' => 'open'] ]);

        // create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_notifications_NotificationOverview');
        
        // setup
        $component->addSelection('notifications', 'Mimoto.CMS_notifications_Notification', $aNotifications);

        // setup page
        $component->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Notification Center',
                    "url" => '/mimoto.cms/notifications'
                )
            )
        );

        // render and send
        return $component->render();
    }

    public function closeNotification(Application $app, $nNotificationId)
    {
        // load
        $notification = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_NOTIFICATION, $nNotificationId);

        // validate
        if (empty($notification) || $notification->getValue('state') != 'open') return new Response('Notification already closed');;

        // change state
        $notification->setValue('state', 'closed');

        // store
        $app['Mimoto.Data']->store($notification);

        // send
        return new Response('Notification closed');
    }
}
