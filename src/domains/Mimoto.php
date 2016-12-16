<?php

// classpath
namespace Mimoto;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Cache\MimotoCacheServiceProvider;
use Mimoto\Form\MimotoFormServiceProvider;
use Mimoto\Log\MimotoLogServiceProvider;
use Mimoto\User\MimotoUserServiceProvider;


/**
 * Mimoto
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class Mimoto
{
    
    /**
     * Constructor
     * @param Application $app
     */
    public function __construct($app)
    {
        // setup templates
        $app['twig']->getLoader()->addPath(dirname(dirname(__FILE__)) . '/userinterface');

        // setup Mimoto services
        $app->register(new MimotoCacheServiceProvider());
        $app->register(new MimotoEntityServiceProvider());
        $app->register(new MimotoAimlessServiceProvider());
        $app->register(new MimotoEventServiceProvider());
        $app->register(new MimotoFormServiceProvider());
        $app->register(new MimotoLogServiceProvider());
        $app->register(new MimotoUserServiceProvider());



        // --- routes ---


        // root
        $app->get('/mimoto.cms', 'Mimoto\\UserInterface\\MimotoCMS\\DashboardController::viewDashboard');

        // main menu
        $app->get('/mimoto.cms/entities', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::viewEntityOverview');
        $app->get('/mimoto.cms/forms', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::viewFormOverview');
        $app->get('/mimoto.cms/components', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::viewComponentOverview');
        $app->get('/mimoto.cms/content', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::viewContentOverview');
        $app->get('/mimoto.cms/actions', 'Mimoto\\UserInterface\\MimotoCMS\\ActionController::viewActionOverview');
        $app->get('/mimoto.cms/users', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::viewUserOverview');

        //$app->get('/mimoto.cms/messages', 'Mimoto\\UserInterface\\MimotoCMS\\MessageController::viewMessages');
        //$app->get('/mimoto.cms/contacts', 'Mimoto\\UserInterface\\MimotoCMS\\ContactController::viewContacts');
        //$app->get('/mimoto.cms/notes', 'Mimoto\\UserInterface\\MimotoCMS\\NoteController::viewNotes');


        // Entity
        $app->get ('/mimoto.cms/entity/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityNew');
        //$app->post('/mimoto.cms/entity/create', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityCreate');
        $app->get ('/mimoto.cms/entity/{nEntityId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityView');
        $app->get ('/mimoto.cms/entity/{nEntityId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityEdit');
        $app->post('/mimoto.cms/entity/{nEntityId}/update', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityUpdate');
        $app->get ('/mimoto.cms/entity/{nEntityId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityDelete');

        // EntityProperty
        $app->get ('/mimoto.cms/entity/{nEntityId}/property/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyNew');
        $app->post('/mimoto.cms/entity/{nEntityId}/property/create', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyCreate');

        $app->get('/mimoto.cms/entityproperty/{nEntityPropertyId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyEdit');
        $app->post('/mimoto.cms/entityproperty/{nEntityPropertyId}/update', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyUpdate');
        $app->get('/mimoto.cms/entityproperty/{nEntityPropertyId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyDelete');

        // EntityPropertySetting
        $app->get('/mimoto.cms/entitypropertysetting/{nEntityPropertySettingId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertySettingEdit');

        // Component
        $app->get ('/mimoto.cms/component/new', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentNew');
        $app->get ('/mimoto.cms/component/{nComponentId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentView');
        $app->get ('/mimoto.cms/component/{nComponentId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentEdit');


        // Entity
        $app->get ('/mimoto.cms/form/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formNew');
        $app->post('/mimoto.cms/form/create', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formCreate');
        $app->get ('/mimoto.cms/form/{nFormId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formView');
        $app->get ('/mimoto.cms/form/{nFormId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formEdit');
        $app->post('/mimoto.cms/form/{nFormId}/update', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formUpdate');
        $app->get ('/mimoto.cms/form/{nFormId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formDelete');



        $app->get('/mimoto.cms/notifications', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::viewNotificationCenter');
        $app->get('/mimoto.cms/notifications/{nNotificationId}/close', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::closeNotification');
        $app->get('/mimoto.cms/notifications/count', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::getNotificationCount');

        $app->get('/mimoto.cms/conversations', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::viewConversationCenter');
        $app->get('/mimoto.cms/conversations/{nConversationId}/close', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::closeConversation');
        $app->get('/mimoto.cms/conversations/count', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::getConversationCount');



        $app->get('/mimoto.cms/actions', 'Mimoto\\UserInterface\\MimotoCMS\\ActionsController::viewActionOverview');



        // --- assets ---

        // javascript
        $app->get('/mimoto.cms/static/js/mimoto.aimless.js', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMimotoAimless');
        $app->get('/mimoto.cms/static/js/mimoto.cms.js', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMimotoCMS');

        // stylesheets
        $app->get('/mimoto.cms/static/css/mimoto.cms.css', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadStylesheetMimotoCMS');

        // images
        // ..
    }

}
