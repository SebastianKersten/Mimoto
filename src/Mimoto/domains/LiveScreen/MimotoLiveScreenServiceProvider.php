<?php

// classpath
namespace Mimoto\LiveScreen;

// Mimoto classes
use Mimoto\LiveScreen\MimotoLiveScreenService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoLiveScreenServiceProvider
 *
 * @author Sebastian Kersten
 */
class MimotoLiveScreenServiceProvider implements ServiceProviderInterface
{
    
    // config
    var $_aEntities;
    
    
    /**
     * Constructor
     * @param array $aEntities
     */
    public function __construct($aEntities)
    {
        // register
        $this->_aEntities = $aEntities;
    }
    
    
    public function register(Application $app)
    {   
        // register
        $app->get('/Mimoto.Aimless/{sEntityType}/{nEntityId}/{sTemplateId}', 'Mimoto\\LiveScreen\\MimotoLiveScreenController::getView');
        
        $app['LiveScreenService'] = $app->share(function($app) {
            return new MimotoLiveScreenService($this->_aEntities, $app);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
