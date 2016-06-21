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
        $aArticles = $app['Mimoto.Data']->find(['type' => 'article']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_overview');
        
        // setup
        $component->addSelection('articles', 'feeditem', $aArticles);
        
        // render and send
        return $component->render();
    }
    
    public function viewExample4(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find(['type' => 'article']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('feed');
        
        // setup
        $component->addSelection('articles', 'feeditem_type', $aArticles);
        
        // render and send
        return $component->render();
    }    
    
    public function viewExample5(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);
        
        // setup
        $component->setPropertyTemplate('subprojects', 'subproject');
        
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
        $component->setPropertyTemplate('subprojects', 'subproject_phase');
        $component->setPropertyFormatter('description', function($sValue) { return substr($sValue, 0, 72).' ..'; });
        $component->setVar('author', 'Sebastian');
        
        // render and send
        return $component->render();
    }
    
    
    
    public function viewExample8(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->get('client', 96);
        
        // setup
        $client->setValue('name', 'IDFA - Modified = '.date("Y:m:d H.i.s"));
        
        // store
        $client = $app['Mimoto.Data']->store($client);
        
        // render and send
        return 'Client updated';
    }
    
    public function viewExample9(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->create('client');
        
        // setup
        $client->setValue('name', 'IDFA');
        
        // store
        $client = $app['Mimoto.Data']->store($client);
        
        // render and send
        return 'New client created';
    }
    
    public function viewExample10(Application $app)
    {
        // load
        $aClients = $app['Mimoto.Data']->find(['type' => 'client']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('client_overview');
        
        // setup
        $component->addSelection('clients', 'client_listitem', $aClients);
        
        // render and send
        return $component->render();
    }
    
    public function viewExample11(Application $app)
    {
        // load
        $aSubprojects = $app['Mimoto.Data']->find(['type' => 'subproject']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('subproject_overview');
        
        // setup
        $component->addSelection('subprojects', 'subproject_examplelistitem', $aSubprojects);
        
        // render and send
        return $component->render();
    }
    
    
    public function viewExample12(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 2);
        
        // setup
        $subproject->setValue('phase', 'archived');
        
        // store
        $subproject = $app['Mimoto.Data']->store($subproject);
        
        // render and send
        return "Subproject updated to 'archived'. Toggle back to <a href='/example13'>'current project'</a>";
    }
    
    public function viewExample13(Application $app)
    {
        
        // mls_contains='client' mls_template='client_listitem'
        
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 2);
        
        // setup
        $subproject->setValue('phase', 'currentproject');
        
        // store
        $subproject = $app['Mimoto.Data']->store($subproject);
        
        // render and send
        return "Subproject updated to 'currentproject'. Toggle to <a href='/example12'>'archived'</a>";
    }
    
    
    
    // --- adding and removing items to an entity's collection ---
    // ---> allowDuplicates = playlist
    // ---> no allowDuplicates = social network (follow users)
    
    
    public function viewExample14(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);
        
        // setup
        $component->setPropertyTemplate('subprojects', 'subproject');
        $component->setPropertyFormatter('description', function($sValue) { return substr($sValue, 0, 72).' ..'; });
        
        // render and send
        return $component->render();
    }
    
    
    public function viewExample15(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        
        
        $project->setValue('name', 'VanMoof.com - '.date("Y:m:d H.i.s"));
        $project->setValue('projectmanager', ceil(rand(1, 3)));
        
        // setup
        $project->addValue('subprojects', 3);
        $project->addValue('subprojects', $subproject);
        
        
        output('$project [AFTER adding subproject]', $project);
        output('$project changes', $project->getChanges());
        
        // store
        $project = $app['Mimoto.Data']->store($project);
        
        // render and send
        return "Subprojects added to project!";
    }
    
    public function viewExample16(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        $subproject = $app['Mimoto.Data']->get('subproject', 4);
        
        // setup
        $project->removeValue('subprojects', $subproject);
        
        // store
        $project = $app['Mimoto.Data']->store($project);
        
        // render and send
        return "Subproject removed from project!";
    }
    
    
    
    
    
    
    
    
    public function viewArticleOverview(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find(['type' => 'article']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_overview');
        
        // setup
        $component->addSelection('articles', 'feeditem_type', $aArticles);
        
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
        
        $aArticles = $app['Mimoto.Data']->find(['type' => $sEntityType]);
        
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
