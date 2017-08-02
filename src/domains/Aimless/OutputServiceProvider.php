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
        $app->get ('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sComponentName}', 'Mimoto\\api\\OutputController::renderEntityView');
        $app->get ('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sComponentName}/{sPropertySelector}', 'Mimoto\\api\\OutputController::renderEntityView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}', 'Mimoto\\api\\OutputController::renderWrapperView');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}/{sPropertySelector}', 'Mimoto\\api\\OutputController::renderWrapperView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}/{sComponentName}/{sPropertySelector}', 'Mimoto\\api\\OutputController::renderWrapperView')->value('sPropertySelector', '');
        $app->get ('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\api\\OutputController::renderForm');

        // new -> replacement for '/Mimoto.Aimless/data' and '/Mimoto.Aimless/wrapper' #todo replace
        $app->post('/mimoto.data/render', 'Mimoto\\api\\OutputController::render');


        $app->post('/Mimoto.Aimless/realtime/collaboration', 'Mimoto\\api\\OutputController::authenticateUser');


        $app->get('/Mimoto.Aimless/media/source/{sPropertySelector}', 'Mimoto\\api\\OutputController::getMediaSource');



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
