<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntityService;

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
    public function __construct($aEntityConfigs)
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
        $app['Mimoto.EntityService'] = $app->share(function($app) {
            return new MimotoEntityService($this->_aEntityConfigs, $app);
        });
    }
    
    /**
     * Boot service
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // noop
    }
    
}
