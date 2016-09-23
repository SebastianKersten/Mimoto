<?php

// classpath
namespace Mimoto\UserInterface;

// Mimoto classes
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;
use SendGrid\Email;
use SendGrid\Mail;
use SendGrid\Content;

// Symfony classes
use Symfony\Component\HttpFoundation\RedirectResponse;


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
        $component->setPropertyComponent('subprojects', 'subproject');
        $component->setPropertyComponent('projectManager', 'projectManager');

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
        $component->setPropertyComponent('subprojects', 'subproject_phase');
        
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
        $component->setPropertyComponent('subprojects', 'subproject_phase');
        $component->setPropertyFormatter('description', function($sValue) { return substr($sValue, 0, 72).' ..'; });
        $component->setVar('author', 'Sebastian');
        
        // render and send
        return $component->render();
    }
    
    
    public function viewExample8(Application $app)
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
    
    public function viewExample8a(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->get('client', 6);
        
        // setup
        $client->setValue('name', 'IDFA - Modified = '.date("Y:m:d H.i.s"));
        
        // store
        $app['Mimoto.Data']->store($client);

        // render and send
        return new RedirectResponse('/example8');
    }
    
    public function viewExample8b(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->create('client');
        
        // setup
        $client->setValue('name', 'New client');
        
        // store
        $app['Mimoto.Data']->store($client);

        // render and send
        return new RedirectResponse('/example8');
    }
    
    
    public function viewExample9(Application $app)
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
    
    
    public function viewExample9a(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 2);

        // setup
        $subproject->setValue('phase', 'archived');

        // store
        $app['Mimoto.Data']->store($subproject);
        
        // render and send
        return new RedirectResponse('/example9');
    }
    
    public function viewExample9b(Application $app)
    {
        
        // mls_contains='client' mls_template='client_listitem'
        
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 2);
        
        // setup
        $subproject->setValue('phase', 'currentproject');
        
        // store
        $app['Mimoto.Data']->store($subproject);
        
        // render and send
        return new RedirectResponse('/example9');
    }

    
    
    public function viewExample10(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);
        
        // setup
        $component->setPropertyComponent('subprojects', 'subproject');
        $component->setPropertyFormatter('description', function($sValue) { return substr($sValue, 0, 72).' ..'; });
        
        // render and send
        return $component->render();
    }
    
    
    public function viewExample10a(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // setup
        $project->setValue('name', 'VanMoof.com - '.date("Y:m:d H.i.s"));
        $project->setValue('projectManager', ceil(rand(1, 3)));

        // add
        $project->addValue('subprojects', 3);

        // add
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        $project->addValue('subprojects', $subproject);
        
        // store
        $app['Mimoto.Data']->store($project);
        
        // render and send
        return new RedirectResponse('/example10');
    }
    
    public function viewExample10b(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        
        // setup
        $project->removeValue('subprojects', 3);
        //$project->removeValue('subprojects', $subproject);
        
        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/example10');
    }
    
    
    public function viewExample11(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects_phase', $project);
        
        // setup
        $component->setPropertyComponent('subprojects', 'subproject_phase');
        
        // render and send
        return $component->render();
    }
    
    public function viewExample11a(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        
        // setup
        $project->addValue('subprojects', $subproject);
        
        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/example11');
    }
    
    public function viewExample11b(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        
        // setup
        $project->removeValue('subprojects', $subproject);
        
        // store
        $app['Mimoto.Data']->store($project);
        
        // render and send
        return new RedirectResponse('/example11');
    }

    public function viewExample11c(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $subproject->setValue('phase', 'request');

        // store
        $app['Mimoto.Data']->store($subproject);

        // render and send
        return new RedirectResponse('/example11');
    }

    public function viewExample11d(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $subproject->setValue('phase', 'archived');

        // store
        $app['Mimoto.Data']->store($subproject);

        // render and send
        return new RedirectResponse('/example11');
    }

    public function viewExample12(Application $app)
    {
        // render and send
        return $this->viewExample7($app);
    }
    
    
    
    public function viewExample13(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->get('client', 1);
        
        // create
        $form = $app['Mimoto.Aimless']->createForm('client', $client);
        
        // 1. page->
        // 2. component->
        // 3. form->
        // 4. stop entity in form en zorg ervoor dat de check daar gedaan wordt. Geen restrictie op veld
        // 5. alles ontvangen wat onvangen mag worden (multiple of single?)
        // 6. entity vast gekoppeld aan form
        // 7. collection ondersteunt verschillende types
        // 8. dropdowns vullen met data (setupField)
        // 9. velden voor invoer komen uit config
        
        // render and send
        return $form->render();
    }




    public function viewExample14(Application $app)
    {

        // 1. Author extends Person


        $person_entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, 1);
        $member_entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, 4);
        $author_entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, 3);


        //error($person_entity);

        //output('_mimoto_entity called "person"', $person_entity);
        //output('_mimoto_entity called "author"', $member_entity);
        //output('_mimoto_entity called "author"', $author_entity);


        $person = $app['Mimoto.Data']->get('person', 1);
        //$member = $app['Mimoto.Data']->get('person', 1);
        $author = $app['Mimoto.Data']->get('author', 1);


        //error($author);


        error(($author->typeOf('person')) ? 'Yes, entity is of type "person"' : 'No, entity is not of type "person"');


        die();


        // load
        $person = $app['Mimoto.Data']->get('person', 1);
        //$author = $app['Mimoto.Data']->get('author', 1);

        // output
        output("Author extends person", $person);

        return '';
    }


    public function viewExample15(Application $app)
    {
        $from = new Email(null, "sebastiankersten@gmail.com");
        $subject = "Hello World from the SendGrid PHP Library";
        $to = new Email(null, "sebastian@decorrespondent.nl");
        $content = new Content("text/plain", "some text here");
        $mail = new Mail($from, $subject, $to, $content);
        $to = new Email(null, "sebastian@decorrespondent.nl");
        $mail->personalization[0]->addTo($to);

        //echo json_encode($mail, JSON_PRETTY_PRINT), "\n";


        $apiKey = getenv('SENDGRID_API_KEY');
        $sg = new \SendGrid($apiKey);

        $request_body = $mail;
        $response = $sg->client->mail()->send()->post($request_body);

        echo $response->statusCode();
        echo $response->body();
        echo $response->headers();
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
