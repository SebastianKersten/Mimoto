<?php

// classpath
namespace Mimoto\UserInterface\examples;

// Mimoto classes
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
 * FormValidationController
 *
 * @author David de Lusenet
 */
class FormValidationController
{

    public function showForm(Application $app)
    {
        // create
        $component = $app['Mimoto.Aimless']->createComponent('formvalidation');

        // render and send
        return $component->render();
    }

}
