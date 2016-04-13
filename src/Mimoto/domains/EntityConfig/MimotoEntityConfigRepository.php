<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;



/**
 * MimotoEntityConfigRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigRepository
{
    
    /**
     * The requested entities
     * @var array
     */
    private $_aEntityConfigs = [];
    
    
    const DBTABLE_ENTITYCONFIGS = '_mimoto_entityconfigs';
    const DBTABLE_ENTITYCONFIGS_PROPERTIES = '_mimoto_entityconfigs_properties';
    const DBTABLE_ENTITYCONFIGS_PROPERTIES_OPTIONS = '_mimoto_entityconfigs_properties_options';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // prepare
        $this->loadAllEntityConfigs();
    }
    
        
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function getAllEntityConfigs()
    {
        return $this->_aEntityConfigs;
    }
    
    
    
    /**
     * Create new entityConfig
     * @return MimotoEntityConfig
     */
    public function create()
    {
        // init and send
        return new MimotoEntityConfig();
    }
    
    /**
     * Get single entity config by id
     * @param int $nId
     * @return ModelClass
     * @throws ModelClassException
     */
    public function get($nId)
    {
        // validate
        if (is_nan($nId) || $nId < 0) { throw new MimotoEntityException("( '-' ) - Sorry, the entity config id '$nId' you passed is not a valid. Should be an integer > 0"); }
        
        
        
//        $pdo->prepare('
//            SELECT * FROM '".self::DBTABLE_ENTITYCONFIGS."'
//            WHERE id = :id');
//
//        $params = array(':id' => $nId);
//        
//        $pdo->execute($params);
        
        
        
//        
//        
//        // load
//        $sQuery = "SELECT * FROM ".self::DBTABLE_ENTITYCONFIGS." WHERE id=".$nId;
//        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
//        $nItemCount = mysql_num_rows($result);
//        
//        // verify
//        if ($nItemCount !== 1)
//        {
//            throw new MimotoEntityException("( '-' ) - Sorry, I can't find the entity config with id='$nId'");
//        }
//        else
//        {
//            // setup
//            $entityConfig = $this->createEntityConfigFromMySQLResult($result, 0);
//            
//            // send
//            return $entityConfig;
//        }
    }
    
    /**
     * Find a collection entities
     * @return Array containing zero or more entities
     */
    public function find(MimotoEntityConfig $entityConfig, $criteria = null)
    {
        
    }
    
    /**
     * Store entity
     * @param entity $entity
     */
    public function store($entity)
    {
        
       
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
    private function loadAllEntityConfigs()
    {
        // load
        $sQuery = "SELECT * FROM ".self::DBTABLE_ENTITYCONFIGS;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // 1. load 3 tables and add to memory (serializable)
        // 2. of uit memory
        
        // store
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // init
            $entityConfig = new MimotoEntityConfig();
            
            // setup
            $entityConfig->setId(mysql_result($result, $i, 'id'));
            $entityConfig->setName(mysql_result($result, $i, 'name'));
            $entityConfig->setMySQLTable(mysql_result($result, $i, 'dbtable'));
            
            // store
            $this->_aEntityConfigs[] = $entityConfig;
        }
        
        $nItemCount = count($this->_aEntityConfigs);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entityConfig = $this->_aEntityConfigs[$i];
            
            $this->composeEntityConfig($entityConfig);
        }
        
        
        // 1. setup rest of the entityConfigs
        // 2. prepare data for storage in memory (json)
    }
    
    /**
     * Create entity config from MySQL result
     * @param MySQL query result $mysqlResult
     * @param int $nIndex
     * @return entity
     */
    private function composeEntityConfig($entityConfig)
    {
        // load
        $sQueryProperties = "SELECT * FROM ".self::DBTABLE_ENTITYCONFIGS_PROPERTIES." WHERE entityconfig_id=".$entityConfig->getId().' ORDER BY sortindex ASC';
        $resultProperties = mysql_query($sQueryProperties) or die('Query failed: ' . mysql_error());
        $nPropertyCount = mysql_num_rows($resultProperties);
        
        // 
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            
            $nPropertyId = mysql_result($resultProperties, $i, 'id');
            $sPropertyName = mysql_result($resultProperties, $i, 'name');
            $sPropertyType = mysql_result($resultProperties, $i, 'type');
            
            
            // load
            $sQueryOptions = "SELECT * FROM ".self::DBTABLE_ENTITYCONFIGS_PROPERTIES_OPTIONS." WHERE property_id=".$nPropertyId;
            $resultOptions = mysql_query($sQueryOptions) or die('Query failed: ' . mysql_error());
            $nOptionCount = mysql_num_rows($resultOptions);

            // 
            $aPropertyOptions = [];
            for ($j = 0; $j < $nOptionCount; $j++)
            {
                $sOptionName = mysql_result($resultOptions, $j, 'option');
                $optionValue = mysql_result($resultOptions, $j, 'value');
                
                $aPropertyOptions[$sOptionName] = $optionValue;
            }
            
            
            switch($sPropertyType)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                    
                    $entityConfig->setValueAsProperty($sPropertyName);
                    
                    // connect entity to data source
                    $entityConfig->connectPropertyToMySQLColumn($sPropertyName, $sPropertyName);
                    break;
                    
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                    
                    // 1. entity-types opslaan in class root en dan de string meegeven, ipv de id
                    
                    $entityConfig->setEntityAsProperty($sPropertyName, $this->getEntityNameById($aPropertyOptions['entityType']));
                    
                    // connect entity to data source
                    $entityConfig->connectPropertyToMySQLColumn($sPropertyName, $sPropertyName.'_id');
                    break;
                    
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                    
                    // 1. pass options, zoals allowDuplicates en verwerk intern in method
                    
                    $entityConfig->setEntityAsProperty($sPropertyName, $aPropertyOptions['allowedEntityType']);
                    break;
            }
            
        }
    }
    
    
    private function getEntityNameById($nId)
    {
        
        $nItemCount = count($this->_aEntityConfigs);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entityConfig = $this->_aEntityConfigs[$i];
            
           if ($entityConfig->getId() === $nId) { return $entityConfig->getName(); }
        }
    }
}
