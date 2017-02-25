<?php

// classpath
namespace Mimoto\UserInterface\examples;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;
use SendGrid\Email;
use SendGrid\Mail;
use SendGrid\Content;

// Symfony classes
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * ExampleController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ExampleController
{

    public function viewExamples(Application $app)
    {
        // create
        $component = $app['Mimoto.Aimless']->createComponent('examples_overview');

        // render and send
        return $component->render();
    }


    // --- actions ---


    public function triggerAction1(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $project->addValue('subprojects', $subproject);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction2(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $project->removeValue('subprojects', $subproject);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction3(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $subproject->setValue('phase', 'request');

        // store
        $app['Mimoto.Data']->store($subproject);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction4(Application $app)
    {
        // load
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $subproject->setValue('phase', 'archived');

        // store
        $app['Mimoto.Data']->store($subproject);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction5(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->get('client', 6);

        // setup
        $client->setValue('name', 'IDFA - Modified = '.date("Y:m:d H.i.s"));

        // store
        $app['Mimoto.Data']->store($client);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction6(Application $app)
    {
        // load
        $client = $app['Mimoto.Data']->create('client');

        // setup
        $client->setValue('name', 'New client');

        // store
        $app['Mimoto.Data']->store($client);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction7(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // setup
        $project->setValue('name', 'VanMoof.com - '.date("Y:m:d H.i.s"));
        $project->setValue('projectManager', (rand(1, 5) == 1) ? null : ceil(rand(1, 3)));

        // add
        $project->addValue('subprojects', 3);

        // add
        $subproject = $app['Mimoto.Data']->get('subproject', 5);
        $project->addValue('subprojects', $subproject);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction8(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // add
        $project->addValue('subprojects', 6);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction9(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);
        $subproject = $app['Mimoto.Data']->get('subproject', 5);

        // setup
        $project->removeValue('subprojects', $subproject);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction10(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // setup
        $project->removeValue('subprojects', 3);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }

    public function triggerAction11(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // setup
        $project->removeValue('subprojects', 6);

        // store
        $app['Mimoto.Data']->store($project);

        // render and send
        return new RedirectResponse('/');
    }


    // --- interface examples ---


    public function viewExample1(Application $app)
    {
        // load
        $article = Mimoto::service('data')->get('article', 1);

        // create
        $component = Mimoto::service('aimless')->createComponent('article', $article);

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
        $component->addSelection('articles', $aArticles, 'feeditem');
        
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
        $component->addSelection('articles', $aArticles, 'feeditem_type');
        
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

        // explain
        $component->setVar('title', 'Project with subprojects');
        $component->setVar('description', 'This project (id = 3) contains a collection of subprojects and every subproject is presented with the same subproject template.');

        // render and send
        return $component->render();
    }
    
    public function viewExample6(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 3);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects_phase', $project);

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
        $component->addSelection('clients', $aClients, 'client_listitem');
        
        // render and send
        return $component->render();
    }
    
    public function viewExample9(Application $app)
    {
        // load
        $aSubprojects = $app['Mimoto.Data']->find(['type' => 'subproject']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('subproject_overview');
        
        // setup
        $component->addSelection('subprojects', $aSubprojects, 'subproject_examplelistitem');
        
        // render and send
        return $component->render();
    }

    public function viewExample10(Application $app)
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

    public function viewExample11(Application $app)
    {
        // load
        $project = $app['Mimoto.Data']->get('project', 2);

        // create
        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);

        // setup
        $component->setPropertyComponent('subprojects', 'subproject_phase');
        $component->setPropertyComponent('projectManager', 'projectManager');

        // explain
        $component->setVar('title', 'Project with subprojects');
        $component->setVar('description', 'This project (id = 2) contains a collection of subprojects and every subproject is presented with the same subproject template.');

        // render and send
        return $component->render();
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





    public function viewDebug1(Application $app, $nEntityId)
    {
        // load
        $entityProperty = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITYPROPERTY, 1);

        error($entityProperty);


        // load
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);


        echo "Entity '".$entity->getValue('name')."' with id=".$entity->getId();

        $aProperties = $entity->getValue('properties');



        output('Properties', $aProperties);


        $nPropertyCount = count($aProperties);
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            $property = $aProperties[$i];

            output('$property', $property, true);

        }


        return 'Done!';
    }



    public function testPusher()
    {

        // Pusher classes
        require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/vendor/pusher/pusher-php-server/lib/pusher.php');

        $config = include(dirname(dirname(dirname(__FILE__))).'/config.php');

        // configure
        $options = array(
            'cluster' => $config->pusher->cluster,
            'encrypted' => $config->pusher->encrypted,
            'host' => 'api-eu.pusher.com'
        );

        $pusher = new \Pusher(
            $config->pusher->auth_key,
            $config->pusher->secret,
            $config->pusher->app_id,
            $options
        );


        $sChannel = 'Aimless';
        $sEvent = 'data.changed';
        $data = (object) array(
            "entityId" => 56,
            "entityType" => "_MimotoAimless__interaction__form",
            "changes" => array(
                (object) array(
                    "propertyName" => "name",
                    "type" => "value",
                    "value" => "aaaaddddeeessaa"
                )
            )
        );

        // send
        $result = $pusher->trigger($sChannel, $sEvent, $data);

        //error($result);
        return 'Event disptached: '.json_encode($data);
    }

    
    
    
    public function viewArticleOverview(Application $app)
    {
        // load
        $aArticles = $app['Mimoto.Data']->find(['type' => 'article']);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent('article_overview');
        
        // setup
        $component->addSelection('articles', $aArticles, 'feeditem_type');
        
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
    
    

    public function viewImageExample(Application $app, $nPersonId)
    {
        // load
        $ePerson = Mimoto::service('data')->get('person', $nPersonId);

        //output('$ePerson id='.$nPersonId, $ePerson);

        // create
        $page = Mimoto::service('aimless')->createComponent('person', $ePerson);

        // render and send
        return $page->render();
    }

    public function viewSelectionExample(Application $app, $nSelectionId)
    {
        // load
        $eSelection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);


        //output('$eSelection id='.$nSelectionId, $eSelection);


        $aEntities = Mimoto::service('data')->select('test');

        // send
        return '<hr>Mimoto done ..';
    }

    public function viewMessageExample(Application $app)
    {
        // load
        $ePerson = Mimoto::service('data')->get('person', 1);

        // alter
        $ePerson->setValue('title', date('Y.m.d H:i:s'));

        // store
        Mimoto::service('data')->store($ePerson);

        // send
        return Mimoto::service('messages')->response('Ja!');
    }

}
