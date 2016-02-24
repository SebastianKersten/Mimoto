<?php

namespace MaidoProjects\Agency;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MaidoProjects\Agency\AgencyService;


class AgencyServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['AgencyService'] = $app->share(function ($app) {
            return new AgencyService();
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
