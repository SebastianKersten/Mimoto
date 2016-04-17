<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * EntitiesController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntitiesController
{
    
    public function getOverview(Application $app)
    {   
        // load
        $aEntityConfigs = $app['Mimoto.EntityConfigService']->getAllEntityConfigs();
        
        return $app['twig']->render(
            'Mimoto.CMS/root.twig',
            array(
                'section' => 'Entities',
                'pagetemplate' => 'Mimoto.CMS/pages/Entities/Overview.twig',
                'aEntityConfigs' => $aEntityConfigs
            )
        );
    }
    
    
    public function createNew(Application $app)
    {   
        // load
        //$aEntityConfigs = $app['Mimoto.EntityConfigService']->getAllEntityConfigs();
        
        return $app['twig']->render(
            'Mimoto.CMS/root.twig',
            array(
                'section' => 'Entity - new',
                'pagetemplate' => 'Mimoto.CMS/pages/Entities/Config.twig'
            )
        );
    }
    
    public function getEntity(Application $app, $nId)
    {   
        // load
        $aAvailableEntities = $app['Mimoto.EntityConfigService']->getAllEntityConfigData();

        
        // init
        $entity = null;
        
        $nItemCount = count($aAvailableEntities);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entityConfig = $aAvailableEntities[$i];
            
           if ($entityConfig->id === $nId)
           {
                $entity = $entityConfig;
                break;
           }
        }
        
        // validate
        if (empty($entity)) { throw new MimotoEntityException("( '-' ) - Sorry, I can't find the entity with id='$nId'"); } 
        
        
        
        // 1. options als parameter doorgeven (maag leeg zijn, kan meerdere items bevatten)
        // 2. id per property doorgeven
        // 3. id per option doorgeven
        // 4. options per property toggle
        // 5. create table on entity create
        // 6. set entity details (name, extends dropdown)
        // 7. add properties to entity
        // 8. add column to table on adding of property
        // 9. check usage when changing a property
        // 10. backup function
        
//        echo "<pre>";
//        print_r($entity);
//        echo "</pre>";
//        die();
        
        
        return $app['twig']->render(
            'Mimoto.CMS/root.twig',
            array(
                'section' => 'Edit entity with id = '.$nId,
                'pagetemplate' => 'Mimoto.CMS/pages/Entities/Config.twig',
                'entity' => $entity,
                'aAvailableEntities' => $aAvailableEntities
            )
        );
    }
    
}
