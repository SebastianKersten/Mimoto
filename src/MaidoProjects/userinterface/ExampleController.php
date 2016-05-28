<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;


/**
 * ExampleController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ExampleController
{
    
    public function viewExample1(Application $app)
    {
        $before = memory_get_usage();
        
        // load
        $entity = $app['Mimoto.Data']->get('client', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('example1', $entity);
        
        $after = memory_get_usage();
        
        echo "<b style='color:#06AFEA'>Memory usage = ".number_format(ceil(($after - $before)/1000), 0, ',', '.')."kb (".number_format(($after - $before), 0, ',', '.')." bytes)</b><br><br>";
        
        // render and send
        return $component->render();
    }
    
    public function viewExample2(Application $app)
    {
        // load
        $entity = $app['Mimoto.Data']->get('author', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('authorpage', $entity);
        
        // setup
        $component->setupProperty('articles', 'feeditem');
        
        // render and send
        return $component->render();
    }
    
    public function viewExample3(Application $app)
    {
        // load
        $entity = $app['Mimoto.Data']->get('client', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('example3', $entity);
        
        // compose
        $component->setVar('blabla', 'xxx');
        
        // render and send
        return $component->render();
    }
    
}
