<?php

// classpath
namespace Mimoto\Aimless;


/**
 * MimotoAimlessRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessRepository
{
    
    // 1. optimalisaties
    // 2. template-configs laden en in geheugen zetten via mysql query ipv MimotoData
    // 3. gebruik redis als geheugen
    // 4. voer composeConfig in MimotoEntityConfigRepository pas uit als er om gevraagd wordt
    // 5. voorbeeld: MimotoEntityConfigRepository
    
    
    // #todo:
    
    private function loadAllEntityConfigData()
    {
        
        // 1. load from cache if present
        // 2. store in cache onLoad
        
        
        // init
        $aAllProperties = [];
        $aAllOptions = [];
        
        
        // load
        $sQueryEntities = "SELECT * FROM ".self::DBTABLE_ENTITIES;
        $resultEntities = mysql_query($sQueryEntities) or die('Query failed: ' . mysql_error());
        $nEntityCount = mysql_num_rows($resultEntities);
        
        // store
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            $entity = (object) array(
                'id' => mysql_result($resultEntities, $i, 'id'),
                'name' => mysql_result($resultEntities, $i, 'name'),
                'extends_id' => mysql_result($resultEntities, $i, 'extends_id'),
                'created' => mysql_result($resultEntities, $i, 'created'),
                'properties' => []
            );
            
            $this->_aEntities[] = $entity;
        }
        
        // load
        $sQueryProperties = "SELECT * FROM ".self::DBTABLE_ENTITIES_PROPERTIES;
        $resultProperties = mysql_query($sQueryProperties) or die('Query failed: ' . mysql_error());
        $nPropertyCount = mysql_num_rows($resultProperties);
        
        // store
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            $property = (object) array(
                'id' => mysql_result($resultProperties, $i, 'id'),
                'name' => mysql_result($resultProperties, $i, 'name'),
                'type' => mysql_result($resultProperties, $i, 'type'),
                'parent_id' => mysql_result($resultProperties, $i, 'parent_id'),
                'sortindex' => mysql_result($resultProperties, $i, 'sortindex'),
                'created' => mysql_result($resultProperties, $i, 'created'),
                'options' => []
            );
            
            $nEntityConfigId = mysql_result($resultProperties, $i, 'entity_id');
            
            $aAllProperties[$nEntityConfigId][] = $property;
        }
        
        // load
        $sQueryOptions = "SELECT * FROM ".self::DBTABLE_ENTITIES_PROPERTIES_OPTIONS;
        $resultOptions = mysql_query($sQueryOptions) or die('Query failed: ' . mysql_error());
        $nOptionCount = mysql_num_rows($resultOptions);
        
        
        // store
        for ($i = 0; $i < $nOptionCount; $i++)
        {
            // init
            $option = (object) array(
                'id' => mysql_result($resultOptions, $i, 'id'),
                'name' => mysql_result($resultOptions, $i, 'name'),
                'value' => mysql_result($resultOptions, $i, 'value'),
                'created' => mysql_result($resultOptions, $i, 'created')
            );
            
            $nEntityConfigPropertyId = mysql_result($resultOptions, $i, 'property_id');
            
            // store
            $aAllOptions[$nEntityConfigPropertyId][$option->name] = $option;
        }
        
        // compose
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // read
            $entity = $this->_aEntities[$i];
            
            // store
            $entity->properties = $aAllProperties[$entity->id];
            
            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                // store
                $property->options = $aAllOptions[$property->id];
            }
        }
    }
    
    
}
