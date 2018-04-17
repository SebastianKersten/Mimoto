<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Core\CoreFormUtils;
use Mimoto\Core\entities\Entity;
use Mimoto\Mimoto;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\EntityConfigTableUtils;
use Mimoto\EntityConfig\EntityConfig;

use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * EntityConfigService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfigService
{

    // config
    private $_aEntityConfigs = [];
    
    // components
    private $_entityConfigRepository;


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param object $entityConfigRepository
     */
    public function __construct($entityConfigRepository)
    {
        // store
        $this->_entityConfigRepository = $entityConfigRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity by id
     * @param int $nId
     * @return EntityConfig The requested entity config
     */
    public function getEntityConfigById($nId)
    {
        try
        {
            $entityConfig = $this->_entityConfigRepository->get($nId);
        }
        catch(MimotoEntityException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $entityConfig;
    }
    
    public function getAllEntityConfigData()
    {
        return $this->_entityConfigRepository->getAllEntityConfigData();
    }
    
    
    
    /**
     * Get entity config by name
     */
    public function getEntityConfigByName($sEntityConfigName)
    {
        return $this->_entityConfigRepository->getEntityConfigByName($sEntityConfigName);
    }
    
    
    /**
     * Get all entities
     */
    public function getAllEntityConfigs()
    {
        return $this->_entityConfigRepository->getAllEntityConfigs();
    }
    
    public function getEntityNameById($nId)
    {
        return $this->_entityConfigRepository->getEntityNameById($nId);
    }
    
    public function getEntityIdByName($sName)
    {
        return $this->_entityConfigRepository->getEntityIdByName($sName);
    }

    public function getPropertyNameById($nId)
    {
        return $this->_entityConfigRepository->getPropertyNameById($nId);
    }

    public function getPropertyIdByName($sName, $nParentEntityTypeId = null)
    {
        return $this->_entityConfigRepository->getPropertyIdByName($sName, $nParentEntityTypeId);
    }

    public function getPropertyTypeById($nId)
    {
        return $this->_entityConfigRepository->getPropertyTypeById($nId);
    }

    public function getEntityNameByPropertyId($nId)
    {
        return $this->_entityConfigRepository->getEntityNameByPropertyId($nId);
    }


    /**
     * Get all entities
     */
    public function find($criteria)
    {
        // init
        $aEntityConfigs= [];

        if (isset($criteria['typeOf']))
        {
            // read
            $sEntityTypeName = $criteria['typeOf'];

            // load
            $aEntityConfigs = $this->_entityConfigRepository->getEntityConfigsTypeOf($sEntityTypeName);
        }

        // send
        return $aEntityConfigs;
    }

    public function getParent($sParentEntityTypeId, $sParentPropertyId, MimotoEntity $child)
    {
        $xId = $child->getId();

        if (substr($xId, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            // create
            $eParent = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITY);

            // setup
            $eParent->setId($xId);
            $eParent->setValue('name', $this->_entityConfigRepository->getEntityNameByFormId($xId));

            // send
            return $eParent;
        }
        else
        {
            if (!MimotoDataUtils::isValidId($sParentEntityTypeId))
            {
                if (MimotoDataUtils::isValidEntityName($sParentEntityTypeId))
                {
                    // convert
                    $sParentEntityTypeId = Mimoto::service('entityConfig')->getEntityIdByName($sParentEntityTypeId);
                }
            }

            if (!MimotoDataUtils::isValidId($sParentPropertyId))
            {
                if (MimotoDataUtils::validatePropertyName($sParentPropertyId))
                {
                    // convert
                    $sParentPropertyId = Mimoto::service('entityConfig')->getPropertyIdByName($sParentPropertyId, $sParentEntityTypeId);
                }
            }

            // validate
            if (empty($sParentEntityTypeId) || empty($sParentPropertyId)) return null;


            // load all connections
            $stmt = Mimoto::service('database')->prepare(
                "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
                "parent_entity_type_id = :parent_entity_type_id && ".
                "parent_property_id = :parent_property_id && ".
                "child_entity_type_id = :child_entity_type_id && ".
                "child_id = :child_id ".
                "ORDER BY parent_id ASC, sortindex ASC"
            );
            $params = array(
                ':parent_entity_type_id' => $sParentEntityTypeId,
                ':parent_property_id' => $sParentPropertyId,
                ':child_entity_type_id' => $child->getEntityTypeId(),
                ':child_id' => $child->getId(),
            );
            $stmt->execute($params);

            // load
            $aResults = $stmt->fetchAll();

            // register
            $nResultCount = count($aResults);

            // validate
            if ($nResultCount == 0)
            {
                return null;
            }
            else
            if ($nResultCount == 1)
            {
                // load
                $entity = Mimoto::service('data')->get($sParentEntityTypeId, $aResults[0]['parent_id']);

                // send
                return $entity;
            }
            else
            {
                // init
                $aParents = [];

                // collect
                for ($nResultIndex = 0; $nResultIndex < $nResultCount; $nResultIndex++)
                {
                    // register
                    $result = $aResults[$nResultIndex];

                    // load
                    $aParents[] = Mimoto::service('data')->get($sParentEntityTypeId, $result['parent_id']);
                }

                // send
                return $aParents;
            }

        }
    }
    


    public function entityIsTypeOf($sTypeOfEntity, $sTypeToCompare)
    {
        return $this->_entityConfigRepository->entityIsTypeOf($sTypeOfEntity, $sTypeToCompare);
    }

}
