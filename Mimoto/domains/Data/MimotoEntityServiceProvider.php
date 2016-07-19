<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntityService;
use Mimoto\Data\MimotoEntityRepository;
use Mimoto\EntityConfig\MimotoEntityConfigRepository;
use Mimoto\EntityConfig\MimotoEntityConfigService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoEntityServiceProider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityServiceProvider implements ServiceProviderInterface
{
    
    // config
    var $_aEntityConfigs;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param array $aEntityConfigs
     */
    public function __construct($aEntityConfigs = [])
    {
        // store
        $this->_aEntityConfigs = $aEntityConfigs;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Register service to app
     * @param Application $app
     */
    public function register(Application $app)
    {
        // register
        $app->get('/mimoto.cms', 'Mimoto\\UserInterface\\DashboardController::viewDashboard');


        $app->get('/mimoto.cms/entities', 'Mimoto\\UserInterface\\EntityController::viewEntityOverview');
        $app->get('/mimoto.cms/entity/{nId}', 'Mimoto\\UserInterface\\EntityController::viewEntity');



        $app->get('/mimoto.cms/entity/new', 'Mimoto\\UserInterface\\EntityController::createNew');



        $app->get('/mimoto.cms/forms', 'Mimoto\\UserInterface\\FormsController::getOverview');
        $app->get('/mimoto.cms/form/new', 'Mimoto\\UserInterface\\FormsController::createNew');
        $app->get('/mimoto.cms/form/{nId}', 'Mimoto\\UserInterface\\FormsController::getForm');
        $app->get('/mimoto.cms/content', 'Mimoto\\UserInterface\\ContentController::getOverview');
        $app->get('/mimoto.cms/content/new', 'Mimoto\\UserInterface\\ContentController::createNew');
        $app->get('/mimoto.cms/content/{nId}', 'Mimoto\\UserInterface\\ContentController::getContent');
        
        
        $app->get('/mimoto.cms/viewentity/{sEntityType}/{nId}', 'Mimoto\\UserInterface\\EntitiesController::viewEntity');
        //$app->get('/mimoto.cms/viewentity/{sEntityType}', 'Mimoto\\UserInterface\\EntitiesController::viewEntity');
        //$app->get('/mimoto.cms/viewentity/{sEntityType}/{nId}', 'Mimoto\\UserInterface\\EntitiesController::viewEntity');
        
        
        // register
        $app['Mimoto.Config'] = $app['Mimoto.EntityConfigService'] = $app->share(function($app) {
            
            // init
            $service = new MimotoEntityConfigService
            (
                new MimotoEntityConfigRepository()
            );
            
            // send
            return $service;
        });
        
        
        // register
        $app['Mimoto.Data'] = $app['Mimoto.EntityService'] = $app->share(function($app) {
            
            // init
            $service = new MimotoEntityService
            (
                $this->_aEntityConfigs, 
                new MimotoEntityRepository($app['Mimoto.EventService']), 
                $app['Mimoto.EntityConfigService']
            );
            
            // send
            return $service;
        });
    }
    
    /**
     * Boot service
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // register
        $GLOBALS['Mimoto.Data'] = $app['Mimoto.Data'];
        $GLOBALS['Mimoto.Config'] = $app['Mimoto.Config'];
    }
    
}
