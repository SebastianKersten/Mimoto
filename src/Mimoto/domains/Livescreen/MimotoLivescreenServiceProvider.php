<?php

// classpath
namespace Mimoto\Livescreen;

// Mimoto classes
use Mimoto\Livescreen\MimotoLivescreenService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoLivescreenServiceProvider
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenServiceProvider implements ServiceProviderInterface
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
        $app->get('/Mimoto.Aimless/{sEntityType}/{nEntityId}/{sTemplateId}', 'Mimoto\\Livescreen\\MimotoLivescreenController::getView');
        
        $app['LivescreenService'] = $app->share(function($app) {
            return new MimotoLivescreenService($this->_aEntities, $app);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
