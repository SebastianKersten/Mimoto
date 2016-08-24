<?php

// classpath
namespace Mimoto\Aimless;

// Silex classes
use Silex\Application;


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
    
}
