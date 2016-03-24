<?php

// classpath
namespace Mimoto\LiveScreen;

// Silex classes
use Silex\Application;


/**
 * MimotoLiveScreenController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoLiveScreenController
{
    
    /**
     * Get view based on entity type and entity id and formatted by template id
     * @param Application $app
     * @param string $sEntityType
     * @param int $nEntityId
     * @param string $sTemplateId
     * @return html Rendered twig template
     */
    public function getView(Application $app, $sEntityType, $nEntityId, $sTemplateId)
    {
        // load
        $entity = $app['LiveScreenService']->getEntityByTypeAndId($sEntityType, $nEntityId);
        $sEntityTemplate = $app['LiveScreenService']->getEntityTemplateTypeAndId($sEntityType, $sTemplateId);
        
        // output
        return $app['twig']->render(
            $sEntityTemplate,
            array(
                $sEntityType => $entity
            )
        );
    }
    
}
