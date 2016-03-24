<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use MaidoProjects\Agency\AgencyService;
use MaidoProjects\Agency\AgencyRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * AgencyServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AgencyServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['AgencyService'] = $app->share(function ($app) {
            return new AgencyService(new AgencyRepository($app['EventService']));
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
