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
        // load
        $person = $app['Mimoto.Data']->get('person', 2);

        // create
        $component = $app['Mimoto.Aimless']->createComponent('examplebase_form');

        // prepare
        $aValues = [
            'name' => $person->getValue('name'),
            'role' => $person->getValue('role')
        ];

        // setup
        $component->addForm('form_person', $aValues);

        // render and send
        return $component->render();
    }
    
}
