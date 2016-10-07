<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\CoreConfig;

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
        $aValues = $requestData->values;
        //$sUniqueId = $requestData->uniqueId; #todo - validate user

        // 3. load form from database
        $aResults = $app['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $sFormName]]);

        // 4. validate if form exists
        if (!isset($aResults[0])) error("Aimless says: Form with name '".$sFormName."' not found in database");
        // #todo - repackage into json



        $form = $aResults[0];
        $aFields = $form->getValue('fields', true);


        // check if data matches the number of fields
        //


        // 3. get form fields

        // 4. connect form fields to values

        // 5. store item


        // a. what if new? create?


        // load
        $client = $app['Mimoto.Data']->get('client', 4);

        $client->setValue('name', $aValues->name);


        $app['Mimoto.Data']->store($client);



        // render and send
        return new Response(json_encode($aValues));
    }

}
