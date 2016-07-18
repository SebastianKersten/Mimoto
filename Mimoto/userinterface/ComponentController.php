<?php

// classpath
namespace Mimoto\UserInterface;

// Mimoto classes
use Mimoto\library\controllers\MimotoController;

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
class EntitiesController extends MimotoController
{
    
    public function viewEntity(Application $app, $sEntityType, $nId)
    {
        // 1. template service
        // 2. load all templates from database into memory
        
        
        
        $entity = $app['Mimoto.Data']->get($sEntityType, $nId);
        
        $component = $app['Mimoto.Aimless']->createComponent('MimotoCMS_EntityItemItem', $entity);

        
        
        $component->setupCollection('subprojects', 'SubprojectListItem');
        
        $component->setupProperty('subprojects.*.client', 'SubprojectListItem');
        
        $component->setVar('blabla', 'xxx');
        
        
        return $component->render();
    }
    
    
    public function editEntity()
    {
        
    }
    
    
    
    
    
    
    
    public function getOverview(Application $app)
    {   
        
        $entities = $app['Mimoto.Data']->find('entity');
        
        
        //new MimotoCollection('entity'); extends \Array
        
        
        // load
        $aEntityConfigs = $app['Mimoto.EntityConfigService']->getAllEntityConfigs();
        
        
        // block
        
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
        // 
        // 11. delete button per property
        // 12. add empty property
        // 13. part of group
        // 14. regex per textinput
        // 15. option value
        
//        echo "<pre>";
//        print_r($aAvailableEntities);
//        echo "</pre>";
//        die();
        
        
        
        
        return $app['twig']->render(
            'Mimoto.CMS/root.twig',
            array(
                'pagetemplate' => 'Mimoto.CMS/pages/Entities/Config.twig',
                'entity' => $entity,
                'aAvailableEntities' => $this->composeAvailableEntities($aAvailableEntities),
                'aPropertyTypes' => $this->composePropertyTypes(),
                'aValueTypes' => $this->composeValueTypes(),
                'aAllowDuplicatesOptions' => $this->composeAllowDuplicatesOptions(),
                'aPropertyNameValidation' => json_encode(['regex' => '^[a-zA-Z][a-zA-Z0-9-_]*?$', 'maxchars' => 10, 'api' => 'Mimoto/form/validate']),
                'aPropertyGroupValidation' => json_encode(['regex' => '^[a-zA-Z]*?[a-zA-Z0-9-_]*?(\.[a-zA-Z][a-zA-Z0-9-_]*?)*$'])
            )
        );
    }
    
    
    private function composePropertyTypes()
    {
        // init
        $aOptions = [];
        
        // options
        $aAvailableOptions = ['value', 'entity', 'collection'];
        
        // compose
        for ($i = 0; $i < count($aAvailableOptions); $i++)
        {
            // setup
            $option = (object) array
            (
                'value' => $aAvailableOptions[$i],
                'label' => $aAvailableOptions[$i]
            );
            
            // store
            $aOptions[] = $option;
        }
                
        // send
        return $aOptions;
    }
    
    private function composeValueTypes()
    {
        // init
        $aOptions = [];
        
        // options
        $aAvailableOptions = ['textline', 'textblock', 'boolean', 'number', 'timestamp','constant'];
        
        // compose
        for ($i = 0; $i < count($aAvailableOptions); $i++)
        {
            // setup
            $option = (object) array
            (
                'value' => $aAvailableOptions[$i],
                'label' => $aAvailableOptions[$i]
            );
            
            // store
            $aOptions[] = $option;
        }
                
        // send
        return $aOptions;
    }
    
    private function composeAvailableEntities($aAvailableEntities)
    {
        // init
        $aOptions = [];
        
        // compose
        for ($i = 0; $i < count($aAvailableEntities); $i++)
        {
            // setup
            $option = (object) array
            (
                'value' => $aAvailableEntities[$i]->id,
                'label' => $aAvailableEntities[$i]->name
            );
            
            // store
            $aOptions[] = $option;
        }
                
        // send
        return $aOptions;
    }
    
    private function composeAllowDuplicatesOptions()
    {
        // init
        $aOptions = [];
        
        // options
        $aAvailableOptions = ['false', 'true'];
        
        // compose
        for ($i = 0; $i < count($aAvailableOptions); $i++)
        {
            // setup
            $option = (object) array
            (
                'value' => $aAvailableOptions[$i],
                'label' => $aAvailableOptions[$i]
            );
            
            // store
            $aOptions[] = $option;
        }
                
        // send
        return $aOptions;
    }
}
