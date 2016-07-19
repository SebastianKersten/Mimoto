<?php

// classpath
namespace Mimoto\CMS;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Cache\MimotoCacheServiceProvider;


/**
 * Mimoto
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class Mimoto
{
    
    /**
     * Constructor
     * @param Application $app
     */
    public function __construct($app)
    {
        // setup templates
        $app['twig']->getLoader()->addPath(dirname(dirname(dirname(__FILE__))) . '/userinterface/templates');

        // setup entities
        $app->register(new MimotoCacheServiceProvider());
        $app->register(new MimotoEntityServiceProvider());
        $app->register(new MimotoAimlessServiceProvider());
        $app->register(new MimotoEventServiceProvider());
    }
}
