<?php

// classpath
namespace Mimoto\Livescreen;

// Silex classes
use Silex\Application;


/**
 * MimotoLivescreenController
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenController
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
        $entity = $app['LivescreenService']->getEntityByTypeAndId($sEntityType, $nEntityId);
        $sEntityTemplate = $app['LivescreenService']->getEntityTemplateTypeAndId($sEntityType, $sTemplateId);
        
        // output
        return $app['twig']->render(
            $sEntityTemplate,
            array(
                $sEntityType => $entity
            )
        );
    }
    
}
