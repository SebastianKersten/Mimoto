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


//        $aRequestValues = array(
//            "project.3.name" => "[".date("H:i:s")."] Bugaboo GTS",
//            "project.3.description" => "[".date("H:i:s")."] Al ruim 15 jaar inspireert Bugaboo honderdduizenden ouders om eropuit te trekken en samen met hun kinderen de wereld te ontdekken. Tegenwoordig is het een vertrouwd straatbeeld: overal stoere, robuuste en tegelijk stijlvolle kinderwagens. Maar toen Max Barenbrug, nu Chief Design Officer bij Bugaboo, in 1994 zo'n kinderwagen ontwierp voor zijn afstudeerproject aan de Design Academy in Eindhoven, was het de eerste in zijn soort. De modulaire, multifunctionele kinderwagen, die net zo makkelijk in de stad als in het bos of op het strand kon worden gebruikt, was destijds een compleet nieuw concept."
//        );
//        $sPublicKey = '11f7d8ac2c8bd9479b39c9d1ad656980';


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

                if (!isset($aEntities['entityType']))
                {
                    $aEntities['entityType'] = (object) array(
                        'entityType' => $aSelectorElements[0],
                        'entityId' => $aSelectorElements[1],
                        'properties' => []
                    );
                }

                $aEntities['entityType']->properties[] = $aSelectorElements[2];
            }
            else
            {
                $aValues[$key] = $value;
            }
        }
        
        error($aEntities);

        // collect
        foreach ($aEntities as $sEntityType => $entityInfo)
        {
            // load
            $entityInfo->entity = $app['Mimoto.Data']->get($entityInfo->entityType, $entityInfo->entityId);

            // load and store
            $aValues[$entityInfo->entityType] = $entityInfo->entity;
        }


        error($aValues);


        // 3. load form
        $form = $app['Mimoto.Forms']->getFormByName($sFormName);

        // 4. prepare
        $formVars = $GLOBALS['Mimoto.Forms']->getFormVars($form, $aValues);
        error($formVars->connectedEntities);
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
                $entityInfo->entity->setValue($sPropertyName, $aRequestValues[$sValueKey]);
            }

            // store
            $app['Mimoto.Data']->store($entityInfo->entity);
        }

        // render and send
        return new Response('Success!');
        //return new Response(json_encode($aValues));
    }

}
