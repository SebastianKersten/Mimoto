<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Data\MimotoEntityConnection;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Form\FormService;

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

    public function renderWrapperView(Application $app, $sEntityType, $nEntityId, $sWrapperName, $sComponentName = null)
    {
        // load
        $entity = $app['Mimoto.Data']->get($sEntityType, $nEntityId);

        // create
        $component = $app['Mimoto.Aimless']->createWrapper($sWrapperName, $sComponentName, $entity);

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
        $formResponse = Mimoto::service('forms')->parseForm($sFormName, $request);

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

    public function uploadImage(Application $app, Request $request)
    {
        // validate
        if (!empty($_FILES))
        {
            $sTargetDir = Mimoto::value('config')->general->web_root.Mimoto::value('config')->media->upload_dir;
            $sOriginalFileName = $_FILES['file']['name'];

            // create
            $eFile = Mimoto::service('data')->create(CoreConfig::MIMOTO_FILE);

            // setup
            $eFile->setValue('path', Mimoto::value('config')->media->upload_dir);
            $eFile->setValue('originalName', $sOriginalFileName);

            // store
            Mimoto::service('data')->store($eFile);


            // analyse
            $aPathParts = pathinfo($_FILES["file"]["name"]);
            $sExtension = $aPathParts['extension'];

            // setup
            $sNewFileName = md5($eFile->getId().$sOriginalFileName).'.'.$sExtension;
            $sTargetFile = $sTargetDir.$sNewFileName;

            // store
            $eFile->setValue('name', $sNewFileName);

            // move to correct location
            if (move_uploaded_file($_FILES['file']['tmp_name'], $sTargetFile))
            {
                // register
                $eFile->setValue('type', $sExtension);
                $eFile->setValue('size', filesize($sTargetFile));

                // store
                Mimoto::service('data')->store($eFile);

                $imageDataResponse = (object) array(
                    'file_id' => $eFile->getEntityTypeName().'.'.$eFile->getId()
                );

                // send success
                return new JsonResponse($imageDataResponse, 200);
            }
            else
            {
                // send error
                return new JsonResponse((object) array('result' => 'Image NOT uploaded! '.date("Y.m.d H:i:s")), 500);
            }

        }
    }
}
