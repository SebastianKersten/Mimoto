<?php

// classpath
namespace Momkai\UserInterface;

// Silex classes
use Silex\Application;


/**
 * CaseController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ExampleController
{

    public function viewHome(Application $app, $nId)
    {
        // load
        $article = $app['Mimoto.Data']->get('case', $nId);

        // create
        $page = $app['Mimoto.Aimless']->createPage('home', $article);

        // render and send
        return $page->render();
    }

    public function viewWork(Application $app, $nId) {}

    public function viewCase(Application $app, $nId)
    {
        // load
        $article = $app['Mimoto.Data']->get('case', $nId);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('case', $article);

        // render and send
        return $page->render();
    }

    public function viewInitiatives(Application $app, $nId) {}

    public function viewPublications(Application $app) {}

    public function viewPublication(Application $app, $nId) {}

    public function viewAbout(Application $app, $nId) {}
    public function viewJobs(Application $app, $nId) {}
    public function viewJob(Application $app, $nId) {}
    public function viewContact(Application $app, $nId) {}



    
}
