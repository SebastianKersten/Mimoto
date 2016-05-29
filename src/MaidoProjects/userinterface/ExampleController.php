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
        // load
        $article = $app['Mimoto.Data']->get('article', 1);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article', $article);
        
        // render and send
        return $component->render();
    }
    
    public function viewExample2(Application $app)
    {        
        // load
        $article = $app['Mimoto.Data']->get('article', 1);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_type', $article);
        
        // render and send
        return $component->render();
    }
    
    public function viewExample3(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find('article');
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_overview');
        
        // setup
        $component->setCollection('articles', 'feeditem', $aArticles);
        
        // render and send
        return $component->render();
    }
    
    public function viewExample4(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find('article');
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('feed');
        
        // setup
        $component->setCollection('articles', 'feeditem_type', $aArticles);
        
        // render and send
        return $component->render();
    }
    
    
    
    
    
    public function viewExample5(Application $app)
    {
        // load
        $entity = $app['Mimoto.Data']->get('client', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('example3', $entity);
        
        // setup
        $component->setupProperty('articles', 'feeditem');
        
        // compose
        $component->setVar('blabla', 'xxx');
        
        // render and send
        return $component->render();
    }
    
    
    
    
    
    public function viewArticleOverview(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find('article');
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_overview');
        
        // setup
        $component->setCollection('articles', 'feeditem_type', $aArticles);
        
        // render and send
        return $component->render();
    }
    
    public function viewArticle(Application $app, $nArticleId)
    {        
        // load
        $article = $app['Mimoto.Data']->get('article', $nArticleId);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_type', $article);
        
        // render and send
        return $component->render();
    }
    
    
}
