<?php

// classpath
namespace Mimoto\Page;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * PageServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class PageServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Page'] = $app['Mimoto.PageService'] = $app->share(function($app)
        {
            return new PageService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('page', $app['Mimoto.Page']);
    }
    
}
