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
        $form = $app['Mimoto.Aimless']->createForm('examplebase_form', 'examplebase_form', $person); // #todo - of array



        // render and send
        return $form->render();









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
