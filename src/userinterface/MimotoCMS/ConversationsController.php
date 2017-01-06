<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
ConversationsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ConversationsController
{
    
    public function viewconversations(Application $app)
    {
//        // load
//        $aNotifications = $app['Mimoto.Data']->find([ 'type' => CoreConfig::MIMOTO_CONVERSATION, 'value' => ['state' => 'open'] ]);
//
//        // create
//        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_conversations_ConversationOverview');
//
//        // setup
//        $component->addSelection('conversations', $aNotifications, 'Mimoto.CMS_notifications_Notification');
//
//        // setup page
//        $component->setVar('pageTitle', array(
//                (object) array(
//                    "label" => 'Notification Center',
//                    "url" => '/mimoto.cms/notifications'
//                )
//            )
//        );
//
//        // render and send
//        return $component->render();
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

    public function getConversationCount(Application $app)
    {
        // load
        //$aConversations = $app['Mimoto.Data']->find([ 'type' => CoreConfig::MIMOTO_CONVERSATION, 'value' => ['state' => 'open'] ]);

        // create
        //$component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_conversations_ConversationOverviewSmall');

        // setup
        //$component->addSelection('conversations', $aConversations, 'Mimoto.CMS_conversations_ConversationSmall');

        // render and send
        return new JsonResponse((object) array(
            'count' => 0, //count($aConversations),
            'notifications' => '' //$component->render()
        ));
    }
}
