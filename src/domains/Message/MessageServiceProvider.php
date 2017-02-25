<?php

// classpath
namespace Mimoto\Message;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MessageServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MessageServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Message'] = $app['Mimoto.MessageService'] = $app->share(function($app)
        {
            return new MessageService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('messages', $app['Mimoto.Message']);
    }
    
}
