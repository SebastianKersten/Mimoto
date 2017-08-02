<?php

// classpath
namespace Mimoto\api;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * DataController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DataController
{

    /**
     * Render data
     */
    public function select(Application $app, Request $request)
    {
        // 1. register
        $sPropertySelector  = $request->get('sPropertySelector');
        $xSelection         = $request->get('xSelection');

        // 2. select
        $aItems = Mimoto::service('data')->select($xSelection);

        // 3. create
        $popup = Mimoto::service('output')->createPopup('MimotoCMS_popups_Select');

        // 4. inject
        $popup->addSelection('items', $aItems);

        // 5. render and send
        return $popup->render();
    }

}
