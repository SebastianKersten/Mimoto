<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Data\MimotoEntityConnection;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Form\MimotoFormService;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * MimotoAimlessController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessController
{
    
    /**
     * Get view based on entity type and entity id and formatted by component id
     * @param Application $app
     * @param string $sEntityType
     * @param int $nEntityId
     * @param string $sComponentId
     * @return html Rendered twig template
     */
    public function renderEntityView(Application $app, $sEntityType, $nEntityId, $sComponentId)
    {
        // load
        $entity = $app['Mimoto.Data']->get($sEntityType, $nEntityId);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent($sComponentId, $entity);
        
        // render and send
        return $component->render();
    }

    /**
     * Parse
     * @param Application $app
     * @param string $sFormName
     * @return json The result
     */
    public function parseForm(Application $app, Request $request, $sFormName)
    {
        // parse
        $formResponse = $app['Mimoto.Forms']->parseForm($sFormName, $request);

        // render and send
        return new JsonResponse($formResponse);
    }

    public function validateFormField(Application $app, Request $request, $sFormName, $sFieldId, $nValidationId)
    {

    }


    public function authenticateUser(Application $app, Request $request)
    {
        // Pusher classes
        require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/vendor/pusher/pusher-php-server/lib/pusher.php');
        $config = require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

        if ($app['Mimoto.User']->getUserId())
        {
            // configure
            $options = array(
                $config->pusher->cluster,
                $config->pusher->encrypted
            );

            $pusher = new \Pusher(
                $config->pusher->auth_key,
                $config->pusher->secret,
                $config->pusher->app_id,
                $options
            );

            return $pusher->socket_auth($request->get('channel_name'), $request->get('socket_id'));
        }
        else
        {
            header('', true, 403);
            return "Forbidden";
        }
    }
}
