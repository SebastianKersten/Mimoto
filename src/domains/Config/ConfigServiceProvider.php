<?php

// classpath
namespace Mimoto\Config;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Config\ConfigService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * ConfigServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    // configuration
    private $_sPathToConfigFile;


    public function __construct($_sPathToConfigFile)
    {
        // register
        $this->_sPathToConfigFile = $_sPathToConfigFile;
    }


    public function register(Application $app)
    {
        $app['Mimoto.ConfigService'] = $app->share(function ($app)
        {
            $service = new ConfigService($this->_sPathToConfigFile);
            
            return $service;
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('config', $app['Mimoto.ConfigService']);
    }
}
