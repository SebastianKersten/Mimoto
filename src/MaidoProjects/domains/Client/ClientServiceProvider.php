<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\ClientService;
use MaidoProjects\Client\ClientRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * ClientServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ClientServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ClientService'] = $app->share(function ($app) {
            return new ClientService(new ClientRepository($app['EventService']));
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
