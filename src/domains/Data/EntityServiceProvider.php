<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\EntityConfig\EntityConfigRepository;
use Mimoto\EntityConfig\EntityConfigService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * EntityServiceProider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityServiceProvider implements ServiceProviderInterface
{
    
    // config
    private $_aEntityConfigs;
    
    
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
        $app['Mimoto.Config'] = $app['Mimoto.EntityConfigService'] = $app->share(function($app) {

            // init
            $service = new EntityConfigService
            (
                new EntityConfigRepository()
            );

            // send
            return $service;
        });


        // register
        $app['Mimoto.Data'] = $app['Mimoto.EntityService'] = $app->share(function($app) {

            // init
            $service = new EntityService
            (
                $this->_aEntityConfigs,
                new EntityRepository($app['Mimoto.EventService']),
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
        Mimoto::setService('data', $app['Mimoto.Data']);
        Mimoto::setService('config', $app['Mimoto.Config']);
    }
    
}
