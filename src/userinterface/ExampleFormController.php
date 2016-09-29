<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;


/**
 * ExampleFormController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ExampleFormController
{
    
    public function viewExampleForm1(Application $app)
    {

        //$entityId = $app['Mimoto.Config']->getEntityNameByPropertyId(1);


        // load
        $person = $app['Mimoto.Data']->get('person', 2);

        // create
        $form = $app['Mimoto.Aimless']->createForm('examplebase_form', $person, 'examplebase_form'); // #todo - of array
        // 1. laatste template-parameter is optioneel als template voor het form

        // 2. create form from nothing? or only als option



        // a. indien 3e param niet emegegeven, dan lege twig gebruiken
        // b. tweede param id is data of multiple data sets
        // c. eerste param is component group voor input-group


        // 1. main-theme for all input elements
        // 2. connect by conditional (type = ... -> dan template x)
        // 3. form kan standalone zijn
        // 4. add base-twig to component (via sIdentifier)



        // a. component settingsPurperen69



        // render and send
        return $form->render();



        // load
//        $project = $app['Mimoto.Data']->get('project', 3);
//
//        // create
//        $component = $app['Mimoto.Aimless']->createComponent('project_withsubprojects', $project);
//
//        // setup
//        $component->setPropertyComponent('subprojects', 'subproject');
//        $component->setPropertyComponent('projectManager', 'projectManager');
//
//        // render and send
//        return $component->render();






//        // prepare
//        $aValues = [
//            'name' => $person->getValue('name'),
//            'role' => $person->getValue('role')
//        ];


        // 1. get property by id from connection



        //$component = $app['Mimoto.Aimless']->createComponent('examplebase_form');

        // setup
        //$component->addForm('form_person', $person); // #todo - of array


    }
    
}