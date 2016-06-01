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
        $component->addCollection('articles', 'feeditem', $aArticles);
        
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
        $component->addCollection('articles', 'feeditem_type', $aArticles);
        
        // render and send
        return $component->render();
    }
    
    
    
    
    
    public function viewExample5(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
//        echo '<pre>';
//        print_r($project);
//        echo '</pre>';
        
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);
        
        // setup
        $component->setPropertyTemplate('subprojects', 'subproject');
        
        
        // compose
        //$component->setPropertyFormatter('blabla', 'xxx');
        //$component->addVar('blabla', 'xxx');
        
        // render and send
        return $component->render();
    }
    
    
    
    public function viewExample6(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects_phase', $project);
        
        // setup
        $component->setPropertyTemplate('subprojects', 'subproject_phase');
        
        // compose
        //$component->setFormatter('blabla', 'xxx');
        //$component->setVar('blabla', 'xxx');
        
        // render and send
        return $component->render();
    }
    
    
    
    public function viewExample7(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects_filter', $project);
        
        // setup
        $component->setupProperty('subprojects', 'subproject_state');
        
        // compose
        //$component->setFormatter('blabla', 'xxx');
        //$component->setVar('blabla', 'xxx');
        
        // render and send
        return $component->render();
    }
    
    public function viewExample8(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('article', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_custom', $project);
        
        // compose
        $component->setFormatter('blabla', 'xxx');
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
        $component->addCollection('articles', 'feeditem_type', $aArticles);
        
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
    
    public function viewMemcacheExample(Application $app)
    {
        
        function microtime_float()
        {
            list($usec, $sec) = explode(" ", microtime());
            return ((float)$usec + (float)$sec);
        }
        
        
        $time_start = microtime_float();
        $before = memory_get_usage();
        
        
        $article = $app['Mimoto.Cache']->getValue('article.1');
        
        
        if ($article === false)
        {
            echo 'article.1 not found!<br>';
            
            // load
            $article = $app['Mimoto.Data']->get('article', 1);
            
            
            $articleCache = (object) array(
                'title' => $article->getValue('title'),
                'lede' => $article->getValue('lede'),
                'body' => $article->getValue('body'),
                'type' => $article->getValue('type')
            );
            
            $app['Mimoto.Cache']->setValue('article.1', $articleCache, false, 10) or die ("Failed to save data at the server - Silent fail!!");
        }
        else
        {
            echo 'article.1:';
            echo '<pre>';
            print_r($article);
            echo '</pre>';
        }
        
        
        $after = memory_get_usage();
        echo "<br><br><hr><b style='color:#06AFEA'>Memory usage = ".number_format(ceil(($after - $before)/1000), 0, ',', '.')."kb (".number_format(($after - $before), 0, ',', '.')." bytes)</b><br><br>";
        
        $time_end = microtime_float();
        $time = $time_end - $time_start;
        echo "It took $time seconds to load data\n";
        
        
        return '<br>Done!';
    }
    
    
    
    public function viewAllArticlesInMemcache(Application $app, $sEntityType)
    {
        
        $aArticles = $app['Mimoto.Data']->find($sEntityType);
        
        for ($i = 0; $i < count($aArticles); $i++)
        {
            $article = $aArticles[$i];
            
            $sEntityId = $sEntityType.'.'.$article->getId();
            
            $cachedArticle = $app['Mimoto.Cache']->getValue($sEntityId);
            
            echo $sEntityId.' in cache: '.(($cachedArticle === false) ? 'no' : '<b>YES</b>').'<br>';
            
                
        }
        
        return '<br>Done!';
    }
    
}
