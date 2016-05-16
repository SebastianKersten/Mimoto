<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoAimlessServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessServiceProvider implements ServiceProviderInterface
{
    
    // config
    var $_aViewModels;
    
    
    /**
     * Constructor
     * @param array $aViewModels
     */
    public function __construct($aViewModels)
    {
        // register
        $this->_aViewModels = $aViewModels;
    }
    
    
    public function register(Application $app)
    {   
        // register
        $app->get('/Mimoto.Aimless/{sEntityType}/{nEntityId}/{sTemplateId}', 'Mimoto\\Aimless\\MimotoAimlessController::getView');
        
        $app['Mimoto.AimlessService'] = $app->share(function($app) {
            return new MimotoAimlessService($this->_aViewModels, $app);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
