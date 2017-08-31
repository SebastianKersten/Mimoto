<?php

// classpath
namespace Mimoto;

// Mimoto classes
use Mimoto\Action\ActionServiceProvider;
use Mimoto\Core\CoreConfig;
use Mimoto\Event\EventServiceProvider;
use Mimoto\Aimless\OutputServiceProvider;
use Mimoto\Data\DataServiceProvider;
use Mimoto\Cache\CacheServiceProvider;
use Mimoto\Form\FormServiceProvider;
use Mimoto\Log\LogServiceProvider;
use Mimoto\User\UserServiceProvider;
use Mimoto\Selection\SelectionServiceProvider;
use Mimoto\Message\MessageServiceProvider;
use Mimoto\Session\SessionServiceProvider as MimotoSessionServiceProvider;
//use Mimoto\Page\PageServiceProvider;

use Mimoto\UserInterface\MimotoCMS\SessionController;

use Mimoto\Aimless\UserViewModel; // move this to a central setup (output-service)


// Silex classes
use Silex\Application;
use Silex\Provider\SessionServiceProvider;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\SecurityServiceProvider;


/**
 * Mimoto
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class Mimoto
{
    // silex
    private static $_app;

    private static $_aServices = [];
    private static $_aValues = [];
    private static $_aGlobalValues = [];

    private static $_bDebugMode = false;


    const DATA = 'data';
    const CONFIG = 'config';
    const AIMLESS = 'aimless';



    public static function isInDebugMode()
    {
        return self::$_bDebugMode;
    }



    /**
     * Constructor
     * @param Application $app
     */
    public function __construct($app, $bEnableCache = false, $sProjectName = 'mimoto')
    {
        // register
        Mimoto::$_app = $app;


        // setup templates
        $app['twig']->getLoader()->addPath(dirname(dirname(__FILE__)) . '/userinterface');

        // configure defaults
        Mimoto::setValue('page.layout.default', 'MimotoCMS_layout_Page');
        Mimoto::setValue('popup.layout.default', 'MimotoCMS_layout_Popup');

        // setup Silex services
        $app->register(new SessionServiceProvider());

        // setup Mimoto services
        $app->register(new CacheServiceProvider($bEnableCache));
        $app->register(new DataServiceProvider());
        $app->register(new LogServiceProvider());
        $app->register(new OutputServiceProvider());
        $app->register(new EventServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new UserServiceProvider());
        $app->register(new ActionServiceProvider());
        $app->register(new SelectionServiceProvider());
        $app->register(new MessageServiceProvider());
        $app->register(new MimotoSessionServiceProvider());
        //$app->register(new PageServiceProvider());



        // --- installation ---

        $app->get ('/'.$sProjectName.'.cms/setup', 'Mimoto\\UserInterface\\MimotoCMS\\SetupController::welcome');
        // werkt alleen als config.php niet bestaat én geen users
        // check connection


        // Slack worker - vars - abstract - actions
        // opslaan in config.php

        // rollen: superuser


        // configuration/roles
        // configuration/services
        // #uitleg over locatie browser? folder?

        // overview screen met icons, uitleg en button naar vervolgpagina


        //$app->post('/'.$sProjectName.'/data/select', 'Mimoto\\api\\DataController::select');






        // --- access control ---

        $app->post('/'.$sProjectName.'.cms', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::login');
        $app->get ('/'.$sProjectName.'.cms/connect', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::connect'); // return domain & port
        $app->get ('/'.$sProjectName.'.cms/logout', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::logout');

        $app->get ('/'.$sProjectName.'/initialize', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::initialize');
        $app->get ('/'.$sProjectName.'/logon', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::logon');
        $app->get ('/'.$sProjectName.'/recent/{sPropertySelector}', 'Mimoto\\UserInterface\\MimotoCMS\\SessionController::recent');


        // --- runtime ---

        $app->get ('/'.$sProjectName.'.cms/configuration/gearman', 'Mimoto\\UserInterface\\MimotoCMS\\WorkerController::overview');
        $app->get ('/'.$sProjectName.'.cms/workers/data', 'Mimoto\\UserInterface\\MimotoCMS\\WorkerController::data');
        $app->get ('/'.$sProjectName.'.cms/workers/slack', 'Mimoto\\UserInterface\\MimotoCMS\\WorkerController::slack');
        $app->get ('/'.$sProjectName.'.cms/heartbeat', 'Mimoto\\UserInterface\\MimotoCMS\\HeartbeatController::viewOverview');



        // --- data manipulation
        $app->post('/'.$sProjectName.'/data/edit', 'Mimoto\\api\\DataController::edit');
        $app->post('/'.$sProjectName.'/data/add', 'Mimoto\\api\\DataController::add');
        $app->post('/'.$sProjectName.'/data/remove', 'Mimoto\\api\\DataController::remove');
        $app->post('/'.$sProjectName.'/data/select', 'Mimoto\\api\\DataController::select');
        $app->post('/'.$sProjectName.'/data/set', 'Mimoto\\api\\DataController::set');
        $app->post('/'.$sProjectName.'/data/create', 'Mimoto\\api\\DataController::create');
        $app->post('/'.$sProjectName.'/data/clear', 'Mimoto\\api\\DataController::clear');



        // --- routes ---


        // root
        $app->get('/'.$sProjectName.'.cms', 'Mimoto\\UserInterface\\MimotoCMS\\DashboardController::viewDashboard');

        // main menu
        $app->get('/'.$sProjectName.'.cms/entities', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::viewEntityOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/selections', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::viewSelectionOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/configuration', 'Mimoto\\UserInterface\\MimotoCMS\\ConfigurationController::overview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/configuration/formatting', 'Mimoto\\UserInterface\\MimotoCMS\\FormattingOptionController::overview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/configuration/userroles', 'Mimoto\\UserInterface\\MimotoCMS\\UserRolesController::overview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/configuration/services', 'Mimoto\\UserInterface\\MimotoCMS\\ServicesController::overview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/components', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::viewComponentOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/contentsections', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::viewContentSectionOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/actions', 'Mimoto\\UserInterface\\MimotoCMS\\ActionController::viewActionOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/users', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::viewUserOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/api', 'Mimoto\\UserInterface\\MimotoCMS\\APIController::viewAPIOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/flows', 'Mimoto\\UserInterface\\MimotoCMS\\FlowController::viewFlowOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/pages', 'Mimoto\\UserInterface\\MimotoCMS\\PageController::overview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        //$app->get('/'.$sProjectName.'.cms/messages', 'Mimoto\\UserInterface\\MimotoCMS\\MessageController::viewMessages');
        //$app->get('/'.$sProjectName.'.cms/contacts', 'Mimoto\\UserInterface\\MimotoCMS\\ContactController::viewContacts');
        //$app->get('/'.$sProjectName.'.cms/notes', 'Mimoto\\UserInterface\\MimotoCMS\\NoteController::viewNotes');


        // Entity
        $app->get ('/'.$sProjectName.'.cms/entity/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // EntityProperty
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/property/new', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->post('/'.$sProjectName.'.cms/entity/{nEntityId}/property/create', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyCreate')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get('/'.$sProjectName.'.cms/entityproperty/{nEntityPropertyId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/entityproperty/{nEntityPropertyId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertyDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // EntityPropertySetting
        $app->get('/'.$sProjectName.'.cms/entitypropertysetting/{nEntityPropertySettingId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::entityPropertySettingEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // Instance
        $app->get ('/'.$sProjectName.'.cms/instance/{sEntityType}/all/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::instanceDeleteAll')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/instance/{sEntityType}/{nId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\EntityController::instanceDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');



        // User
        $app->get ('/'.$sProjectName.'.cms/user/new', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::userNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/user/{nUserId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::userView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/user/{nUserId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::userEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/user/{nUserId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::userDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get ('/'.$sProjectName.'.cms/account', 'Mimoto\\UserInterface\\MimotoCMS\\UserController::editCurrentUser')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');


        // Component
        $app->get ('/'.$sProjectName.'.cms/component/{nComponentId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::componentView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // Selection
        $app->get ('/'.$sProjectName.'.cms/selection/{nSelectionId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\SelectionController::selectionView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');


        // Formatting options
        $app->get ('/'.$sProjectName.'.cms/configuration/formattingOption/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormattingOptionController::formattingOptionNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/formattingOption/{nItemId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\FormattingOptionController::formattingOptionView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/formattingOption/{nItemId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormattingOptionController::formattingOptionEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/formattingOption/{nItemId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormattingOptionController::formattingOptionDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');


        // User roles
        $app->get ('/'.$sProjectName.'.cms/configuration/userRole/new', 'Mimoto\\UserInterface\\MimotoCMS\\UserRolesController::userRoleNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/userRole/{nItemId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\UserRolesController::userRoleView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/userRole/{nItemId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\UserRolesController::userRoleEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/configuration/userRole/{nItemId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\UserRolesController::userRoleDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // User pages
        $app->get ('/'.$sProjectName.'.cms/page/new', 'Mimoto\\UserInterface\\MimotoCMS\\PageController::pageNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/page/{nItemId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\PageController::pageView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/page/{nItemId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\PageController::pageEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/page/{nItemId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\PageController::pageDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');


        // Layout
        $app->get ('/'.$sProjectName.'.cms/layout/{nLayoutId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ComponentController::layoutView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get ('/'.$sProjectName.'.cms/layout/{nLayoutId}/layoutcontainer/new', 'Mimoto\\UserInterface\\MimotoCMS\\LayoutController::layoutContainerNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/layoutcontainer/{nLayoutContainerId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\LayoutController::layoutContainerEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/layoutcontainer/{nLayoutContainerId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\LayoutController::layoutContainerDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // Content
        $app->get ('/'.$sProjectName.'.cms/contentsection/new', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/contentsection/{nContentSectionId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/contentsection/{nContentSectionId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/contentsection/{nContentSectionId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\ContentSectionController::contentSectionDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get ('/'.$sProjectName.'.cms/content/{nContentId}', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/content/{nContentId}/new', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentGroupItemNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/content/{nContentId}/{sContentTypeName}/{nContentItemId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentGroupItemEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/content/{nContentId}/{sContentTypeName}/{nContentItemId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\ContentController::contentGroupItemDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        // Form
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/form/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formNew')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/entity/{nEntityId}/form/autogenerate', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formAutogenerate')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/form/{nFormId}/view', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formView')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/form/{nFormId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/form/{nFormId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get ('/'.$sProjectName.'.cms/form/{nFormId}/field/new', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldNew_fieldTypeSelector')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/form/{nFormId}/field/new/{nFormFieldTypeId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldNew_fieldForm')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/formfield/{nFormFieldTypeId}/{nFormFieldId}/edit', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/formfield/{nFormFieldTypeId}/{nFormFieldId}/delete', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldDelete')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get ('/'.$sProjectName.'.cms/formfield/{sInputFieldType}/{sInputFieldId}/add/{sPropertySelector}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldListItemAdd')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/formfield/{sInputFieldType}/{sInputFieldId}/add/{sPropertySelector}/{sOptionId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldListItemAdd')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/formfield/{sInputFieldType}/{sInputFieldId}/edit/{sPropertySelector}/{sInstanceType}/{sInstanceId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldListItemEdit')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get ('/'.$sProjectName.'.cms/formfield/{sInputFieldType}/{sInputFieldId}/remove/{sPropertySelector}/{sInstanceType}/{sInstanceId}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::formFieldListItemRemove')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get('/'.$sProjectName.'.cms/form/list/sort/{sPropertySelector}/{nConnectionId}/{nOldIndex}/{nNewIndex}', 'Mimoto\\UserInterface\\MimotoCMS\\FormController::updateSortindex')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get('/'.$sProjectName.'.cms/notifications', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::viewNotificationCenter')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/notifications/{nNotificationId}/close', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::closeNotification')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/notifications/closeall', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::closeAllNotifications')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/notifications/count', 'Mimoto\\UserInterface\\MimotoCMS\\NotificationsController::getNotificationCount')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');

        $app->get('/'.$sProjectName.'.cms/conversations', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::viewConversationCenter')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/conversations/{nConversationId}/close', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::closeConversation')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');
        $app->get('/'.$sProjectName.'.cms/conversations/count', 'Mimoto\\UserInterface\\MimotoCMS\\ConversationsController::getConversationCount')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');



        $app->get('/'.$sProjectName.'.cms/actions', 'Mimoto\\UserInterface\\MimotoCMS\\ActionsController::viewActionOverview')->before('Mimoto\\UserInterface\\MimotoCMS\\SessionController::validateCMSUser');



        // --- assets ---

        // javascript
        $app->get('/'.$sProjectName.'/static/js/mimoto.js', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMimoto');
        $app->get('/'.$sProjectName.'/static/js/mimoto.js.map', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMapMimoto');
        $app->get('/'.$sProjectName.'/static/js/mimoto.cms.js', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMimotoCMS');
        $app->get('/'.$sProjectName.'/static/js/mimoto.cms.js.map', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadJavascriptMapMimotoCMS');

        // stylesheets
        $app->get('/'.$sProjectName.'/static/css/mimoto.cms.css', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadStylesheetMimotoCMS');

        // fonts
        $app->get('/'.$sProjectName.'/static/fonts/futura/4d6d50ec-b049-44ba-a001-e847c3e2dc79.ttf', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaTtf');
        $app->get('/'.$sProjectName.'/static/fonts/futura/94fe45a6-9447-4224-aa0f-fa09fe58c702.eot', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaEot');
        $app->get('/'.$sProjectName.'/static/fonts/futura/475da8bf-b453-41ee-ab0e-bd9cb250e218.woff', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaWoff');
        $app->get('/'.$sProjectName.'/static/fonts/futura/cb9d11fa-bd41-4bd9-8b8f-34ccfc8a80a2.woff2', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadFontFuturaWoff2');

        // images
        $app->get('/'.$sProjectName.'/static/images/mimoto_logo.png', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadImageLogo');
        $app->get('/'.$sProjectName.'/static/images/mimoto_logo_collapsed.png', 'Mimoto\\UserInterface\\MimotoCMS\\AssetController::loadImageLogoCollapsed');


        $app->error(function (\Exception $e, $code) use ($app) {

            switch ($code)
            {
                case 404:

                    // register
                    $sRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                    // render and output
                    $result = Mimoto::service('output')->renderRoute($sRoute);

                    if ($result !== false)
                    {
                        // if instanceof Response override
                        return new Response($result, 404 /* ignored */, array('X-Status-Code' => 200));
                    }
                    else
                    {
                        // handle
                        if (!empty(Mimoto::service('route')))
                        {
                            // render custom route
                            $result = Mimoto::service('route')->render($app, $sRoute);

                            return new Response($result, 404 /* ignored */, array('X-Status-Code' => 200));
                        }
                        else
                        {
                            Mimoto::error('Route not found .. need to output 404');
                        }
                    }
                    break;

                default:

                    if ($app['debug']) {
                        // in debug mode we want to get the regular error message
                        return;
                    }

                    $message = 'We are sorry, but something went terribly wrong.';
            }

            return new Response($message);
        });
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

    public static function globalValue($sKey)
    {
        if (isset(self::$_aGlobalValues[$sKey]))
        {
            return self::$_aGlobalValues[$sKey];
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

    public static function setGlobalValue($sKey, $value)
    {
        // store
        self::$_aGlobalValues[$sKey] = $value;
    }

    public static function runInDebugMode($bDebugMode)
    {
        // toggle
        self::$_bDebugMode = $bDebugMode;
    }

    public static function user()
    {
        // init
        $eUser = Mimoto::service('session')->currentUser();

        // validate
        if (empty($eUser)) return null;

        // create
        $component = Mimoto::service('output')->createComponent('', $eUser);

        // wrap into viewmodel
        $viewModel = new UserViewModel($component);

        // send
        return $viewModel;
    }

    public static function output($sTitle, $data = null, $bScream = false)
    {
        // validate
        if (!self::$_bDebugMode) return;

        // style
        $sTextColor = ($bScream) ? '#ff0000' : '#06afea';
        $sBorderColor = ($bScream) ? '#ff0000' : '#858585';
        $sBackgroundColor = ($bScream) ? '#ffbbbb' : '#f5f5f5';

        echo '<div style="background-color:'.$sBackgroundColor.';border:solid 1px '.$sBorderColor.';padding:20px">';
        if (is_string($sTitle)) echo '<h2><b style="color:'.$sTextColor.'">'.$sTitle.'</b></h2><hr>';
        echo '<pre style="width:100%">';
        if (!empty($data)) echo print_r($data, true);
        echo '</pre>';
        echo '</div>';
        echo '<br>';
    }

    public static function error($data)
    {
        // validate
        if (!self::$_bDebugMode) return;

        echo '<div style="display:inline-block; background-color:#DF5B57;color:#ffffff;padding:15px 20px 0 20px; text-overflow: scroll">';
        echo '<div>';
        echo '<h2><b style="font-size:larger;">Error</b></h2><hr style="border:0;height:1px;background:#ffffff">';
        echo '<pre>';
        if (empty($data))
        {
            echo "<i style='font-style:italic'>No data provided</i>";
        }
        else
        {
            echo print_r($data, true);
        }
        echo '</pre>';
        echo '</div>';
        echo '<br>';

        //throw new \Exception('oh oh, computer says oops!');
        die();
    }
}
