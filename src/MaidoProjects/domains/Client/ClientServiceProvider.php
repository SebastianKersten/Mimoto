<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\ClientService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;



class ClientServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ClientService'] = $app->share(function ($app) {
            return new ClientService();
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
