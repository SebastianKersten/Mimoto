<?php

// classpath
namespace Mimoto;

// Mimoto classes
use Mimoto\Action\ActionServiceProvider;
use Mimoto\Event\EventServiceProvider;
use Mimoto\Aimless\AimlessServiceProvider;
use Mimoto\Data\EntityServiceProvider;
use Mimoto\Cache\CacheServiceProvider;
use Mimoto\Form\FormServiceProvider;
use Mimoto\Log\LogServiceProvider;
use Mimoto\User\UserServiceProvider;
use Mimoto\Selection\SelectionServiceProvider;
use Mimoto\Message\MessageServiceProvider;


/**
 * Mimoto
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class Mimoto
{

    private static $_aServices = [];
    private static $_aValues = [];


    const DATA = 'data';
    const CONFIG = 'config';
    const AIMLESS = 'aimless';


    /**
     * Constructor
     * @param Application $app
     */
    public function __construct($app, $bEnableCache = false)
    {
        // setup templates
        $app['twig']->getLoader()->addPath(dirname(dirname(__FILE__)) . '/userinterface');

        // setup Mimoto services
        $app->register(new CacheServiceProvider($bEnableCache));
        $app->register(new EntityServiceProvider());
        $app->register(new LogServiceProvider());
        $app->register(new AimlessServiceProvider());
        $app->register(new EventServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new UserServiceProvider());
        $app->register(new ActionServiceProvider());
        $app->register(new SelectionServiceProvider());
        $app->register(new MessageServiceProvider());



        // --- routes ---


        // root
        $app->get('/mimoto.cms', 'Mimoto\\UserInterface\\MimotoCMS\\DashboardController::viewDashboard');

        // main menu
        $app->get('/mimoto.cms/entities', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::viewEntityOverview');
        $app->get('/mimoto.cms/selections', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::viewSelectionOverview');
        $app->get('/mimoto.cms/contentsections', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::viewContentSectionOverview');
        $app->get('/mimoto.cms/actions', 'Mimoto\\UserInterface\\MimotoCMS\\ActionController::viewActionOverview');
        $app->get('/mimoto.cms/users', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::viewUserOverview');

        //$app->get('/mimoto.cms/messages', 'Mimoto\\UserInterface\\MimotoCMS\\MessageController::viewMessages');
        //$app->get('/mimoto.cms/contacts', 'Mimoto\\UserInterface\\MimotoCMS\\ContactController::viewContacts');
        //$app->get('/mimoto.cms/notes', 'Mimoto\\UserInterface\\MimotoCMS\\NoteController::viewNotes');


        // Entity
        $app->get ('/mimoto.cms/entity/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityNew');
        $app->get ('/mimoto.cms/entity/{nEntityId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityView');
        $app->get ('/mimoto.cms/entity/{nEntityId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityEdit');
        $app->get ('/mimoto.cms/entity/{nEntityId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityDelete');

        // EntityProperty
        $app->get ('/mimoto.cms/entity/{nEntityId}/property/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyNew');
        $app->post('/mimoto.cms/entity/{nEntityId}/property/create', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyCreate');

        $app->get('/mimoto.cms/entityproperty/{nEntityPropertyId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyEdit');
        $app->get('/mimoto.cms/entityproperty/{nEntityPropertyId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyDelete');

        // EntityPropertySetting
        $app->get('/mimoto.cms/entitypropertysetting/{nEntityPropertySettingId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertySettingEdit');

        // Component
        $app->get ('/mimoto.cms/entity/{nEntityId}/component/new', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentNew');
        $app->get ('/mimoto.cms/component/{nComponentId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentView');
        $app->get ('/mimoto.cms/component/{nComponentId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentEdit');
        $app->get ('/mimoto.cms/component/{nComponentId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentDelete');

        // Content
        $app->get ('/mimoto.cms/selection/new', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionNew');
        $app->get ('/mimoto.cms/selection/{nSelectionId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionView');
        $app->get ('/mimoto.cms/selection/{nSelectionId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionEdit');
        $app->get ('/mimoto.cms/selection/{nSelectionId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionDelete');

        $app->get ('/mimoto.cms/selection/{nSelectionId}/rule/new', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionRuleNew');
        $app->get ('/mimoto.cms/selectionrule/{nSelectionRuleId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionRuleEdit');
        $app->get ('/mimoto.cms/selectionrule/{nSelectionRuleId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionRuleDelete');

        // Content
        $app->get ('/mimoto.cms/contentsection/new', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionNew');
        $app->get ('/mimoto.cms/contentsection/{nContentSectionId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionView');
        $app->get ('/mimoto.cms/contentsection/{nContentSectionId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionEdit');
        $app->get ('/mimoto.cms/contentsection/{nContentSectionId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionDelete');

        $app->get ('/mimoto.cms/content/{nContentId}', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentEdit');
        $app->get ('/mimoto.cms/content/{nContentId}/new', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentGroupItemNew');
        $app->get ('/mimoto.cms/content/{nContentId}/{sContentTypeName}/{nContentItemId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentGroupItemEdit');

        // Form
        $app->get ('/mimoto.cms/entity/{nEntityId}/form/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formNew');
        $app->get ('/mimoto.cms/form/{nFormId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formView');
        $app->get ('/mimoto.cms/form/{nFormId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formEdit');
        $app->get ('/mimoto.cms/form/{nFormId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formDelete');

        $app->get ('/mimoto.cms/form/{nFormId}/field/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldNew_fieldTypeSelector');
        $app->get ('/mimoto.cms/form/{nFormId}/field/new/{nFormFieldTypeId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldNew_fieldForm');
        $app->get ('/mimoto.cms/formfield/{nFormFieldTypeId}/{nFormFieldId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldEdit');
        $app->get ('/mimoto.cms/formfield/{nFormFieldTypeId}/{nFormFieldId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldDelete');

        $app->get ('/mimoto.cms/formfield/add/{nFormFieldTypeId}/{nFormFieldId}/{sPropertySelector}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldItemAddToList');
        $app->get ('/mimoto.cms/formfield/add/{nFormFieldTypeId}/{nFormFieldId}/{sPropertySelector}/{sItemId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldItemAddToList');

        $app->get ('/mimoto.cms/formfielditem/{nFormFieldItemId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldItemDelete');

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

        // fonts
        $app->get('/mimoto.cms/static/fonts/futura/4d6d50ec-b049-44ba-a001-e847c3e2dc79.ttf', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaTtf');
        $app->get('/mimoto.cms/static/fonts/futura/94fe45a6-9447-4224-aa0f-fa09fe58c702.eot', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaEot');
        $app->get('/mimoto.cms/static/fonts/futura/475da8bf-b453-41ee-ab0e-bd9cb250e218.woff', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaWoff');
        $app->get('/mimoto.cms/static/fonts/futura/cb9d11fa-bd41-4bd9-8b8f-34ccfc8a80a2.woff2', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaWoff2');

        // images
        $app->get('/mimoto.cms/static/images/mimoto_logo.png', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadImageLogo');
        $app->get('/mimoto.cms/static/images/mimoto_logo_collapsed.png', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadImageLogoCollapsed');
        $app->get('/mimoto.cms/dynamic/avatar.png', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadImageAvatar');
    }



    public static function service($sServiceName)
    {
        if (isset(self::$_aServices[$sServiceName]))
        {
            return self::$_aServices[$sServiceName];
        }
        else
        {
            return null;
        }
    }

    public static function value($sKey)
    {
        if (isset(self::$_aValues[$sKey]))
        {
            return self::$_aValues[$sKey];
        }
        else
        {
            return null;
        }
    }


    public static function setService($sServiceName, $service)
    {
        // store
        self::$_aServices[$sServiceName] = $service;
    }

    public static function setValue($sKey, $value)
    {
        // store
        self::$_aValues[$sKey] = $value;
    }

    public function runInDebugMode()
    {
        // #todo
    }
}
