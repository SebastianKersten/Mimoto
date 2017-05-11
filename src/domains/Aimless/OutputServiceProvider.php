<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * OutputServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        // register
        $app->get ('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sComponentName}', 'Mimoto\\Aimless\\MimotoAimlessController::renderEntityView');
        $app->get ('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sComponentName}/{sPropertySelector}', 'Mimoto\\Aimless\\MimotoAimlessController::renderEntityView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}', 'Mimoto\\Aimless\\MimotoAimlessController::renderWrapperView');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}/{sPropertySelector}', 'Mimoto\\Aimless\\MimotoAimlessController::renderWrapperView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}/{sComponentName}/{sPropertySelector}', 'Mimoto\\Aimless\\MimotoAimlessController::renderWrapperView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\Aimless\\MimotoAimlessController::renderForm');


        $app->post('/mimoto.data/render', 'Mimoto\\Aimless\\MimotoAimlessController::render');


        $app->post('/Mimoto.Aimless/realtime/collaboration', 'Mimoto\\Aimless\\MimotoAimlessController::authenticateUser');


        $app->get('/Mimoto.Aimless/media/source/{sPropertySelector}', 'Mimoto\\Aimless\\MimotoAimlessController::getMediaSource');



        $app['Mimoto.Output'] = $app['Mimoto.OutputService'] = $app->share(function($app)
        {
            return new OutputService($app['Mimoto.Data'], $app['Mimoto.Forms'], Mimoto::service('log'), Mimoto::service('twig'));
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('output', $app['Mimoto.Output']);
    }
    
}
