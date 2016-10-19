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
        $sPublicKey = '906394777c7666665a297969b76415ef';

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
            // load
            $entityInfo->entity = $app['Mimoto.Data']->get($entityInfo->entityType, $entityInfo->entityId);

            // load and store
            $aValues[$entityInfo->entityType] = $entityInfo->entity;
        }


        // 3. load form
        $form = $app['Mimoto.Forms']->getFormByName($sFormName);

        // 4. prepare
        $formVars = $GLOBALS['Mimoto.Forms']->getFormVars($form, $aValues);

        // 5. authenticate
        if ($sPublicKey !== $GLOBALS['Mimoto.User']->getUserPublicKey(json_encode($formVars->connectedEntities))) error('Public key is incorrect!');


        // #todo
        // move to Service (store form) FormService ->

        // #question
        // Hoe omgaan met nieuwe items? wel name/typeid maar geen id -> if no id -> create() i.p.v. get()



        // collect
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

            // store
            $app['Mimoto.Data']->store($entityInfo->entity);
        }

        // render and send
        return new Response('Success!');
        //return new Response(json_encode($aValues));
    }

    public function validateFormField(Application $app, Request $request, $sFormName, $sFieldId, $nValidationId)
    {

    }

}
