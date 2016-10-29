<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;

// Silex classes
use Mimoto\Data\MimotoDataUtils;
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
     * Get view based on entity type and entity id and formatted by template id
     * @param Application $app
     * @param string $sEntityType
     * @param int $nEntityId
     * @param string $sTemplateId
     * @return html Rendered twig template
     */
    public function renderEntityView(Application $app, $sEntityType, $nEntityId, $sTemplateId)
    {
        // load
        $entity = $app['Mimoto.Data']->get($sEntityType, $nEntityId);
        
        // create
        $component = $app['Mimoto.Aimless']->createComponent($sTemplateId, $entity);
        
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
        // 1. load request data
        $requestData = json_decode($request->getContent());

        // 2. register values
        $aRequestValues = $requestData->values;
        $sPublicKey = $requestData->publicKey;

        // get all vars and entities
        $aValues = [];
        $aEntities = [];
        foreach ($aRequestValues as $key => $value)
        {
            // filter
            if (strpos($key, '.') !== false)
            {
                // prepare
                $aSelectorElements = explode('.', $key);

                // validate
                if (count($aSelectorElements) != 3) continue; // #todo - silent fail - possible misabuse
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[0])) continue;
                if (!MimotoDataUtils::isValidEntityId($aSelectorElements[1])) continue;
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[2])) continue;

                // register
                $sEntityType = $aSelectorElements[0];
                $nEntityId = $aSelectorElements[1];
                $sPropertyName = $aSelectorElements[2];

                if (!isset($aEntities[$sEntityType]))
                {
                    $aEntities[$sEntityType] = (object) array(
                        'entityType' => $sEntityType,
                        'entityId' => $nEntityId,
                        'properties' => []
                    );
                }

                $aEntities[$sEntityType]->properties[] = $sPropertyName;
            }
            else
            {
                $aValues[$key] = $value;
            }
        }

        // collect
        foreach ($aEntities as $sEntityType => $entityInfo)
        {
            if ($entityInfo->entityId == CoreConfig::ENTITY_NEW)
            {
                // create
                $entityInfo->entity = $app['Mimoto.Data']->create($entityInfo->entityType);
            }
            else
            {
                // load
                $entityInfo->entity = $app['Mimoto.Data']->get($entityInfo->entityType, $entityInfo->entityId);
            }

            // load and store
            $aValues[$entityInfo->entityType] = $entityInfo->entity;
        }


        // 3. load form
        $form = $app['Mimoto.Forms']->getFormByName($sFormName);

        // 4. prepare
        $formVars = $GLOBALS['Mimoto.Forms']->getFormVars($form, $aValues);

        // 5. authenticate
        if ($sPublicKey !== $GLOBALS['Mimoto.User']->getUserPublicKey(json_encode($formVars->connectedEntities)))
        {
            $GLOBALS['Mimoto.Log']->error('No permission to submit form', "The form with name <b>".$sFormName."</b> has an incorrect public key", true);
        }


        // #todo
        // 1. move to Service (store form) FormService ->



        $formResponse = (object) array( //new MimotoFormResponse();
            'status' => '?',
            'formName' => $sFormName,
            'errors' => []
        );


        // collect
        $bAnyNewEntity = false;
        foreach ($aEntities as $sEntityType => $entityInfo)
        {
            // parse
            $nPropertyCount = count($entityInfo->properties);
            for ($i = 0; $i < $nPropertyCount; $i++)
            {
                // register
                $sPropertyName = $entityInfo->properties[$i];

                // compose
                $sValueKey = $entityInfo->entityType.'.'.$entityInfo->entityId.'.'.$sPropertyName;

                // update
                $entityInfo->entity->setValue($sPropertyName, $aRequestValues->$sValueKey);
            }


            // prepare response
            $bIsNew = (empty($entityInfo->entity->getId())) ? true : false;

            // store
            $app['Mimoto.Data']->store($entityInfo->entity);


            // compose response
            if ($bIsNew)
            {
                // toggle
                $bAnyNewEntity = true;

                // init if not yet defined
                if (!isset($formResponse->newEntities)) $formResponse->newEntities = [];

                // register
                $formResponse->newEntities[$sEntityType] = (object) array(
                    'selector' => $sEntityType.'.'.CoreConfig::ENTITY_NEW,
                    'id' => $sEntityType.'.'.$entityInfo->entity->getId()
                );
            }
        }



        // in case of change selectors due to a nemly created entity, redetermine public key
        if ($bAnyNewEntity)
        {
            // 1. init
            $aNewValues = [];

            // 2. collect
            foreach ($aEntities as $sEntityType => $entityInfo) { $aNewValues[] = $entityInfo->entity; }

            // 3. load
            $formVars = $GLOBALS['Mimoto.Forms']->getFormVars($form, $aNewValues);

            // 4. define
            $formResponse->newPublicKey = $GLOBALS['Mimoto.User']->getUserPublicKey(json_encode($formVars->connectedEntities));
        }


        // 1. return new ID
        // 2. echo new ID



        // render and send
        return new JsonResponse($formResponse);
        //return new Response(json_encode($aValues));
    }

    public function validateFormField(Application $app, Request $request, $sFormName, $sFieldId, $nValidationId)
    {

    }


    public function authenticateUser(Application $app, Request $request)
    {
        // Pusher classes
        require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/vendor/pusher/pusher-php-server/lib/pusher.php');


        if ($app['Mimoto.User']->getUserId())
        {
            // configure
            $options = array(
                'cluster' => 'eu',
                'encrypted' => true
            );

            $pusher = new \Pusher(
                '55152f70c4cec27de21d',
                '7e72297e347e339cd241',
                '185150',
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
