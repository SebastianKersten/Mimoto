<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * NotificationsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class NotificationsController
{
    
    public function viewNotificationCenter(Application $app)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('aimless')->createComponent('Mimoto.CMS_notifications_NotificationOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Notification Center',
                    "url" => '/mimoto.cms/notifications'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function closeNotification(Application $app, $nNotificationId)
    {
        // load
        $notification = Mimoto::service('data')->get(CoreConfig::MIMOTO_NOTIFICATION, $nNotificationId);

        // validate
        if (empty($notification) || $notification->getValue('state') != 'open') return new Response('Notification already closed');;

        // change state
        $notification->setValue('state', 'closed');

        // store
        Mimoto::service('data')->store($notification);

        // send
        return Mimoto::service('messages')->response('Notification closed');
    }

    public function getNotificationCount(Application $app)
    {
        // load
        $aNotifications = Mimoto::service('data')->find([ 'type' => CoreConfig::MIMOTO_NOTIFICATION, 'value' => ['state' => 'open'] ]);

        // create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_notifications_NotificationOverviewSmall');

        // setup
        $component->addSelection('notifications', $aNotifications, 'Mimoto.CMS_notifications_NotificationSmall');

        // render and send
        return Mimoto::service('messages')->response((object) array(
            'count' => count($aNotifications),
            'notifications' => $component->render()
        ));
    }
}
