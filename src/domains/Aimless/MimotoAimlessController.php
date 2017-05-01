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
    public function renderEntityView(Application $app, $sEntityType, $nEntityId, $sComponentName, $sPropertySelector = null)
    {
        // load
        $entity = Mimoto::service('data')->get($sEntityType, $nEntityId);

        // search
        $connection = $this->_getConnection($sEntityType, $nEntityId, $sPropertySelector);

        // create
        $component = Mimoto::service('output')->createComponent($sComponentName, $entity, $connection);

        // render and send
        return $component->render();
    }

    public function renderWrapperView(Application $app, $sEntityType, $nEntityId, $sWrapperName, $sComponentName = null, $sPropertySelector = null)
    {
        // load
        $entity = Mimoto::service('data')->get($sEntityType, $nEntityId);

        // search
        $connection = $this->_getConnection($sEntityType, $nEntityId, $sPropertySelector);

        // create
        $component = Mimoto::service('output')->createWrapper($sWrapperName, $sComponentName, $entity, $connection);

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
        $formResponse = Mimoto::service('input')->parseForm($sFormName, $request);

        // render and send
        return Mimoto::service('messages')->response($formResponse, 200);
    }

    public function validateFormField(Application $app, Request $request, $sFormName, $sFieldId, $nValidationId)
    {

    }


    public function authenticateUser(Application $app, Request $request)
    {
        // Pusher classes
        require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/pusher/pusher-php-server/lib/pusher.php');
        $config = require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

        if ($app['Mimoto.User']->getUserId()) {
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
        } else {
            header('', true, 403);
            return "Forbidden";
        }
    }

    public function uploadImage(Application $app, Request $request)
    {
        // validate
        if (!empty($_FILES)) {
            $sTargetDir = Mimoto::value('config')->general->web_root . Mimoto::value('config')->media->upload_dir;
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
            $sNewFileName = md5($eFile->getId() . $sOriginalFileName) . '.' . $sExtension;
            $sTargetFile = $sTargetDir . $sNewFileName;

            // store
            $eFile->setValue('name', $sNewFileName);

            // move to correct location
            if (move_uploaded_file($_FILES['file']['tmp_name'], $sTargetFile)) {
                // analyze
                $aImageInfo = getimagesize($sTargetFile);

                // register
                $eFile->setValue('mime', $aImageInfo['mime']);
                $eFile->setValue('size', filesize($sTargetFile));
                $eFile->setValue('width', $aImageInfo[0]);
                $eFile->setValue('height', $aImageInfo[1]);
                $eFile->setValue('aspectRatio', $aImageInfo[0] / $aImageInfo[1]);

                // store
                Mimoto::service('data')->store($eFile);

                $imageDataResponse = (object)array(
                    'file_id' => $eFile->getEntityTypeName() . '.' . $eFile->getId()
                );

                // send success
                return new JsonResponse($imageDataResponse, 200);
            } else {
                // send error
                return new JsonResponse((object)array('result' => 'Image NOT uploaded! ' . date("Y.m.d H:i:s")), 500);
            }

        }
    }


    public function uploadVideo(Application $app, Request $request)
    {
        // validate
        if (!empty($_FILES)) {
            $sTargetDir = Mimoto::value('config')->general->web_root . Mimoto::value('config')->media->upload_dir;
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
            $sNewFileName = md5($eFile->getId() . $sOriginalFileName) . '.' . $sExtension;
            $sTargetFile = $sTargetDir . $sNewFileName;

            // store
            $eFile->setValue('name', $sNewFileName);

            // move to correct location
            if (move_uploaded_file($_FILES['file']['tmp_name'], $sTargetFile)) {
                // analyze
//                $aImageInfo = getimagesize($sTargetFile);
//
//                // register
//                $eFile->setValue('mime', $aImageInfo['mime']);
                $eFile->setValue('size', filesize($sTargetFile));
//                $eFile->setValue('width', $aImageInfo[0]);
//                $eFile->setValue('height', $aImageInfo[1]);
//                $eFile->setValue('aspectRatio', $aImageInfo[0] / $aImageInfo[1]);

                // store
                Mimoto::service('data')->store($eFile);

                $imageDataResponse = (object)array(
                    'file_id' => $eFile->getEntityTypeName() . '.' . $eFile->getId(),
                    'full_path' => '/' . $eFile->getValue('path') . $eFile->getValue('name')
                );

                // send success
                return new JsonResponse($imageDataResponse, 200);
            } else {
                // send error
                return new JsonResponse((object)array('result' => 'Image NOT uploaded! ' . date("Y.m.d H:i:s")), 500);
            }

        }
    }

    public function getMediaSource(Application $app, Request $request, $sPropertySelector)
    {
        // split
        $aParentParts = explode('.', $sPropertySelector);

        // validate
        if (!MimotoDataUtils::isValidId($aParentParts[1])) return Mimoto::service('messages')->response(null);

        // load
        $eParent = Mimoto::service('data')->get($aParentParts[0], $aParentParts[1]);

        // read
        $eFile = $eParent->getValue($aParentParts[2]);

        if (!empty($eFile)) {
            // compose
            $response = (object)array(
                'file_id' => $eFile->getEntityTypeName() . '.' . $eFile->getId(),
                'full_path' => '/' . $eFile->getValue('path') . $eFile->getValue('name')
            );

            // send file info
            return Mimoto::service('messages')->response($response);
        } else {
            // send empty
            return Mimoto::service('messages')->response(null);
        }

    }


    private function _getConnection($sEntityType, $nEntityId, $sPropertySelector)
    {
        // init
        $connection = null;

        // verify
        if (!empty($sPropertySelector)) {
            // split
            $aPropertySelectorElements = explode('.', $sPropertySelector);

            // register
            $sParentEntityTypeName = $aPropertySelectorElements[0];
            $xParentEntityId = $aPropertySelectorElements[1];
            $sParentPropertyName = $aPropertySelectorElements[2];

            // load
            $eParent = Mimoto::service('data')->get($sParentEntityTypeName, $xParentEntityId);

            // validate
            if (!empty($eParent) && $eParent->hasProperty($sParentPropertyName)) {
                if ($eParent->getPropertyType($sParentPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION) {
                    // read
                    $aConnections = $eParent->getValue($sParentPropertyName, true);

                    // search
                    $nConnectionCount = count($aConnections);
                    for ($nConnectionIndex = 0; $nConnectionIndex < $nConnectionCount; $nConnectionIndex++) {
                        // register
                        $parentConnection = $aConnections[$nConnectionIndex];

                        // verify
                        if ($parentConnection->getChildEntityTypeName() == $sEntityType && $parentConnection->getChildId() == $nEntityId) {
                            // register
                            $connection = $parentConnection;
                            break;
                        }
                    }
                }
            }
        }

        // send
        return $connection;
    }

    public function renderForm(Application $app, Request $request, $sFormName)
    {
        // load
        //$eForm = Mimoto::service('input')->getFormByName($sFormname);


        // 1. init popup
        $popup =  Mimoto::service('output')->createPopup();

        // 2. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup content
        $component->addForm(
            $sFormName,
            null,
            [
                //'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.entities',
                //'response' => ['onSuccess' => ['closePopup' => true]]
                'response' => ['onSuccess' => ['dispatchEvent' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $component->render();
    }

}
