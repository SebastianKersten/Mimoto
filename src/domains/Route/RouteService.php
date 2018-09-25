<?php

// classpath
namespace Mimoto\Route;

// Mimoto classes
use Mimoto\Core\entities\ComponentConditional;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\FormattingUtils;
use Mimoto\Core\entities\Component;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\EntityConfigUtils;
use Mimoto\Data\MimotoDataUtils;

use Mimoto\Form\FormService;
use Mimoto\Log\LogService;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



/**
 * OutputService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class RouteService
{

    // services
    private $_pageService;
    private $_apiService;

    // messages
    const ERROR_INCORRECT_PERMISSIONS = 'Sorry, you don`t have the correct permissions';


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($pageService, $apiService)
    {
        // register
        $this->_pageService = $pageService;
        $this->_apiService = $apiService;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    public function render($sPath)
    {
        // 1. load
        $aRoutes = array_merge(
            Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_PAGE]),
            Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_API])
        );

        // 2. find
        $nRouteCount = count($aRoutes);
        for ($nRouteIndex = 0; $nRouteIndex < $nRouteCount; $nRouteIndex++)
        {
            // a. register
            $eRoute = $aRoutes[$nRouteIndex];

            // b. read
            $aPathElements = $eRoute->get('path');

            // c. validate
            if (empty($aPathElements)) continue;

            // d. init
            $sPathRegExp = '';

            // e. compose
            $nPathElementCount = count($aPathElements);
            for ($nPathElementIndex = 0; $nPathElementIndex < $nPathElementCount; $nPathElementIndex++)
            {
                // I. register
                $ePathElement = $aPathElements[$nPathElementIndex];

                // II. toggle
                switch($ePathElement->get('type'))
                {
                    case 'static':

                        $sPathRegExp .= '('.preg_replace('/\//', '\/', $ePathElement->get('staticValue')).')';
                        break;

                    case 'slash':

                        $sPathRegExp .= '(\/)';
                        break;

                    case 'var':

                        $sPathRegExp .= '([^\/]*+)';
                        break;
                }
            }

            // f. verify
            if (preg_match('/^\/'.$sPathRegExp.'$/U', $sPath, $aMatches))
            {
                // I. check permissions
                $aRoles = $eRoute->get('allowedUserRoles');
                if (count($aRoles) > 0)
                {
                    // 1. check permissions
                    $bHasPermission = false;
                    $nRoleCount = count($aRoles);
                    for ($nRoleIndex = 0; $nRoleIndex < $nRoleCount; $nRoleIndex++)
                    {
                        // register
                        $eRole = $aRoles[$nRoleIndex];

                        if (Mimoto::user()->hasRole($eRole->get('name')))
                        {
                            $bHasPermission = true;
                            break;
                        }
                    }

                    // 2. validate
                    if (!$bHasPermission)
                    {
                        // V. toggle
                        switch($eRoute->getType())
                        {
                            case CoreConfig::MIMOTO_API:

                                return (!$eRoute->get('outputRawResponse')) ? Mimoto::service('messages')->response(self::ERROR_INCORRECT_PERMISSIONS, 403) : new Response(self::ERROR_INCORRECT_PERMISSIONS, 403);
                                break;

                            case CoreConfig::MIMOTO_PAGE:

                                return new JsonResponse('Sorry, you don`t have the correct permissions', 403);
                                break;
                        }
                    }
                }

                // II. remove full match
                array_splice($aMatches, 0, 1);

                // III. init
                $aVars = [];

                // IV. find variables
                $nMatchCount = count($aMatches);
                for ($nMatchIndex = 0; $nMatchIndex < $nMatchCount; $nMatchIndex++)
                {
                    // 1. register
                    $value = $aMatches[$nMatchIndex];

                    // 2. register
                    $ePathElement = $aPathElements[$nMatchIndex];

                    // 3. verify and register
                    if ($ePathElement->get('type') == 'var') $aVars[$ePathElement->get('varName')] = $value;
                }

                // V. toggle
                switch($eRoute->getType())
                {
                    case CoreConfig::MIMOTO_API:

                        // 1. verify
                        if ($eRoute->get('isEnabled'))
                        {
                            return $this->_apiService->render($eRoute, $aVars);
                        }
                        else
                        {
                            return new Response('', 404);
                        }
                        break;

                    case CoreConfig::MIMOTO_PAGE:

                        return $this->_pageService->render($eRoute, $aVars);
                        break;
                }

                // VI. skip the rest
                break;
            }
        }

        return false;
    }

}
