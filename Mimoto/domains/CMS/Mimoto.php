<?php

// classpath
namespace Mimoto\CMS;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Cache\MimotoCacheServiceProvider;


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
        $app['twig']->getLoader()->addPath(dirname(dirname(dirname(__FILE__))) . '/userinterface/templates');

        // setup Mimoto services
        $app->register(new MimotoCacheServiceProvider());
        $app->register(new MimotoEntityServiceProvider());
        $app->register(new MimotoAimlessServiceProvider());
        $app->register(new MimotoEventServiceProvider());



        // --- routes ---


        // root
        $app->get('/mimoto.cms', 'Mimoto\\UserInterface\\DashboardController::viewDashboard');

        // main menu
        $app->get('/mimoto.cms/entities', 'Mimoto\\UserInterface\\EntityController::viewEntityOverview');
        $app->get('/mimoto.cms/forms', 'Mimoto\\UserInterface\\FormsController::getOverview');


        // Entity
        $app->get ('/mimoto.cms/entity/new', 'Mimoto\\UserInterface\\EntityController::entityNew');
        $app->post('/mimoto.cms/entity/create', 'Mimoto\\UserInterface\\EntityController::entityCreate');
        $app->get ('/mimoto.cms/entity/{nEntityId}/view', 'Mimoto\\UserInterface\\EntityController::entityView');
        $app->get ('/mimoto.cms/entity/{nEntityId}/edit', 'Mimoto\\UserInterface\\EntityController::entityEdit');
        $app->post('/mimoto.cms/entity/{nEntityId}/update', 'Mimoto\\UserInterface\\EntityController::entityUpdate');
        $app->get ('/mimoto.cms/entity/{nEntityId}/delete', 'Mimoto\\UserInterface\\EntityController::entityDelete');

        // EntityProperty
        $app->get ('/mimoto.cms/entity/{nEntityId}/property/new', 'Mimoto\\UserInterface\\EntityController::entityPropertyNew');
        $app->post('/mimoto.cms/entity/{nEntityId}/property/create', 'Mimoto\\UserInterface\\EntityController::entityPropertyCreate');




//        $app->get('/mimoto.cms/form/new', 'Mimoto\\UserInterface\\FormsController::createNew');
//        $app->get('/mimoto.cms/form/{nId}', 'Mimoto\\UserInterface\\FormsController::getForm');
//        $app->get('/mimoto.cms/content', 'Mimoto\\UserInterface\\ContentController::getOverview');
//        $app->get('/mimoto.cms/content/new', 'Mimoto\\UserInterface\\ContentController::createNew');
//        $app->get('/mimoto.cms/content/{nId}', 'Mimoto\\UserInterface\\ContentController::getContent');

    }
}
