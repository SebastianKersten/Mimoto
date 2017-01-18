<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntityProperty;
use Mimoto\Data\MimotoEntityPropertyInterface;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * MimotoEntityProperty_Collection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty_Collection extends MimotoEntityProperty implements MimotoEntityPropertyInterface
{

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($propertyConfig, $xParentId, $xParentEntityTypeId)
    {
        // forward
        parent::__construct($propertyConfig, $xParentId, $xParentEntityTypeId);

        // init
        $this->_data = (object) array(
            'persistentCollection' => [],
            'currentCollection' => []
        );
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - config ------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get type
     * @return string
     */
    public function getType($sSubpropertySelector = null)
    {
        // #todo - support type of individuel subitem

        return $this->_config->type;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - data --------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get the value of the property
     * @param boolean $bGetConnectionInfo
     * @param string $sSubpropertySelector
     * @return array
     */
    public function getValue($bGetConnectionInfo = false, $sSubpropertySelector = null, $bGetPersistentValue = false)
    {
        // 1. read
        $selector = MimotoDataUtils::getConditionalsAndSubselector($sSubpropertySelector);

        // 2. forward
        if (!empty($selector->subpropertyselector)) { return $this->forwardGetValue($selector->conditionals, $selector->subpropertyselector, $bGetConnectionInfo); }

        // 3. validate
        if (empty($this->_data->currentCollection)) return [];

        // 4. send connection info
        if ($bGetConnectionInfo) { return $this->_data->currentCollection; }

        // 5. send entities
        return $this->loadEntities($selector->conditionals);
    }

    /**
     * Set the value of the property
     * @param mixed $xValue
     * @param string|null $sSubpropertySelector
     */
    public function setValue($xValue, $sSubpropertySelector = null)
    {
        // 1. forward request todo - full support in case of subselector after conditionals
        if (!empty($sSubpropertySelector)) { $this->forwardSetValue($sSubpropertySelector, $xValue); return; }



        // 2. validate
        if (!is_array($xValue)) Mimoto::service('log')->error("Incorrect value for collection property", "The property " . $this->_config->name . " only accepts arrays when using setValue()", true);

        // 3. init
        if (!$this->_bTrackChanges) { $this->_data->persistentCollection = []; }
        $this->_data->currentCollection = [];

        // 4. store
        $nItemCount = count($xValue);
        for ($nItemIndex = 0; $nItemIndex < $nItemCount; $nItemIndex++)
        {
            // 4a. register
            $item = $xValue[$nItemIndex];

            // 4b. create connection
            $connection = MimotoDataUtils::createConnection($item, $this->getParentEntityTypeId(), $this->_config->id, $this->getParentId(), $this->_config->settings->allowedEntityTypes, null, $this->_config->name);

            // 4c. store
            if (!empty($connection))
            {
                if (!$this->_bTrackChanges) { $this->_data->persistentCollection[$nItemIndex] = clone $connection; }
                $this->_data->currentCollection[$nItemIndex] = $connection;
            }
        }
    }

    /**
     * Add value to collection
     * @param $xValue
     * @param string|null $sSubpropertySelector
     * @param string|null $sEntityType
     */
    public function addValue($xValue, $sSubpropertySelector = null, $sEntityType = null)
    {
        // forward #fixme Is this still relevant. Code seems to be missing
        //if (!empty($sSubpropertySelector)) { $this->forwardAddValue($sSubpropertySelector, $xValue); return; }


        // 1. convert
        $xEntityTypeId = Mimoto::service('config')->getEntityIdByName($sEntityType);

        // 2. assist
        if (empty($xEntityTypeId))
        {
            if (count($this->_config->settings->allowedEntityTypes) == 1)
            {
                // 2a. auto select
                $xEntityTypeId = $this->_config->settings->allowedEntityTypes[0]->id;
            }
            else
            {
                // 2b. report missing configuration
                Mimoto::service('log')->error("Missing entity type on added item", "Please define the type of the item you arring adding to the collection '".$this->_config->name."'", true);
                return;
            }
        }

        // 3. create connection
        $connection = MimotoDataUtils::createConnection($xValue, $this->getParentEntityTypeId(), $this->_config->id, $this->getParentId(), $this->_config->settings->allowedEntityTypes, $xEntityTypeId, $this->_config->name);

        // 4. validate
        if (empty($connection)) return;

        // 5. manage duplicates
        if (!$this->_config->settings->allowDuplicates)
        {
            $nCurrentCollectionCount = count($this->_data->currentCollection);
            for ($nCurrentCollectionIndex = 0; $nCurrentCollectionIndex < $nCurrentCollectionCount; $nCurrentCollectionIndex++)
            {
                if (!empty($connection->getChildId()) && $this->_data->currentCollection[$nCurrentCollectionIndex]->getChildId() == $connection->getChildId())
                {
                    return;
                }
            }
        }

        // 6. define position
        $nSortIndex = count($this->_data->currentCollection);

        // 7. setup
        $connection->setSortIndex($nSortIndex);

        // 8. store
        if (!$this->_bTrackChanges) { $this->_data->persistentCollection[$nSortIndex] = clone $connection; }
        $this->_data->currentCollection[$nSortIndex] = $connection;
    }

    /**
     * Remove value from collection
     * @param $xValue
     * @param string|null $sSubpropertySelector
     * @param string|null $sEntityType
     */
    public function removeValue($xValue, $sSubpropertySelector = null, $sEntityType = null)
    {
        // forward #fixme Is this still relevant. Code seems to be missing
        //if (!empty($sSubpropertySelector)) { $this->forwardRemoveValue($sSubpropertySelector, $xValue); return; }



        // 1. convert
        $xEntityTypeId = Mimoto::service('config')->getEntityIdByName($sEntityType);

        // 2. assist
        if (empty($xEntityTypeId))
        {


            if (count($this->_config->settings->allowedEntityTypes) == 1)
            {
                // 2a. auto select
                $xEntityTypeId = $this->_config->settings->allowedEntityTypes[0]->id;
            }
            else
            {
                // 2b. report missing configuration
                Mimoto::service('log')->error("Missing entity type on added item", "Please define the type of the item you arring adding to the collection '".$this->_config->name."'", true);
                return;
            }
        }

        // 3. create connection
        $connection = MimotoDataUtils::createConnection($xValue, $this->getParentEntityTypeId(), $this->_config->id, $this->getParentId(), $this->_config->settings->allowedEntityTypes, $xEntityTypeId, $this->_config->name);


        // --- HERE --------------------------------------------------------------------------------------------
        // 1. bij duplicates verwijder allemaal
        // 2. hoe connection id verwijderen? (sortindex / id en connection id niet aanraken?)


        // manage duplicates
        // if (!$property->config->settings->allowDuplicates)

        $nCurrentCollectionCount = count($this->_data->currentCollection);
        for ($nCurrentCollectionIndex = 0; $nCurrentCollectionIndex < $nCurrentCollectionCount; $nCurrentCollectionIndex++)
        {
            if (MimotoDataUtils::connectionsAreSimilar($this->_data->currentCollection[$nCurrentCollectionIndex], $connection))
            {
                // remove
                if (!$this->_bTrackChanges) { array_splice($this->_data->persistentCollection, $nCurrentCollectionIndex, 1); }
                array_splice($this->_data->currentCollection, $nCurrentCollectionIndex, 1);

                // correct
                $nCurrentCollectionIndex--;
                $nCurrentCollectionCount--;
            }
        }
    }




    // ----------------------------------------------------------------------------
    // --- Public methods - change management -------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get Changes
     * @return object Collection containing of all changed properties as key/value pairs
     */
    public function getChanges()
    {
        // init
        $result = (object) array(
            'hasChanges' => false,
            'changes' => null
        );


        // init
        $aAddedItems = [];
        $aUpdatedItems = [];
        $aRemovedItems = [];
        $nCurrentItemCount = count($this->_data->currentCollection);


        if (!empty($this->_data->currentCollection))
        {
            $nCurrentCollectionCount = count($this->_data->currentCollection);
            for ($c = 0; $c < $nCurrentCollectionCount; $c++)
            {
                $currentItem = $this->_data->currentCollection[$c];

                // add new items
                if (empty($currentItem->getId()) || $currentItem->isNew())
                {
                    $aAddedItems[] = $currentItem;
                    continue;
                }

                // add updated items
                if (!empty($this->_data->persistentCollection))
                {
                    $nPersistentCollectionCount = count($this->_data->persistentCollection);
                    for ($p = 0; $p < $nPersistentCollectionCount; $p++)
                    {
                        $persistentItem = $this->_data->persistentCollection[$p];

                        if ($persistentItem->getId() == $currentItem->getId())
                        {
                            if ($persistentItem->getSortIndex() != $currentItem->getSortIndex())
                            {
                                $aUpdatedItems[] = $currentItem;
                                break;
                            }
                        }
                    }


                }
            }
        }

        // add removed items
        if (!empty($this->_data->persistentCollection))
        {
            $nPersistentCollectionCount = count($this->_data->persistentCollection);
            for ($p = 0; $p < $nPersistentCollectionCount; $p++)
            {
                // register
                $persistentItem = $this->_data->persistentCollection[$p];

                // init
                $bItemFound = false;

                // search
                $nCurrentCollectionCount = count($this->_data->currentCollection);
                for ($c = 0; $c < $nCurrentCollectionCount; $c++)
                {
                    // register
                    $currentItem = $this->_data->currentCollection[$c];

                    if ($currentItem->getId() == $persistentItem->getId())
                    {
                        $bItemFound = true;
                        break;
                    }
                }

                if (!$bItemFound) { $aRemovedItems[] = $persistentItem; }
            }
        }

        if (count($aAddedItems) > 0 || count($aUpdatedItems) > 0 || count($aRemovedItems) > 0)
        {
            $result->hasChanges = true;
            $result->changes = (object) array(
                'added' => $aAddedItems,
                'updated' => $aUpdatedItems,
                'removed' => $aRemovedItems,
                'count' => $nCurrentItemCount
            );
        }

        // send
        return $result;
    }

    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // delete
        $this->_data->persistentCollection = [];

        if (!empty($this->_data->currentCollection))
        {
            $nCurrentCollectionCount = count($this->_data->currentCollection);
            for ($k = 0; $k < $nCurrentCollectionCount; $k++)
            {
                $this->_data->persistentCollection[$k] = clone $this->_data->currentCollection[$k];
            }
        }
    }



    // ----------------------------------------------------------------------------
    // --- Private methods - data utils -------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Forward getValue request
     * @param $sPropertySelector
     * @param $bGetConnectionInfo
     * @return mixed|null
     */
    private function forwardGetValue($aConditionals, $sSubpropertySelector, $bGetConnectionInfo)
    {

        // NOT SUPPORTED YET
        die('MimotoEntityProperty_Collection.forwardGetValue - NOT SUPPORTED YET');
        // 1. getConditionalsAndSubselector ondersteunt nog geen subselector

        // 1. find collection that matches the conditionals
        // 2. forward subselector request


//        // 1. get single []
//        // 2. getlist based on single query, or multiple items
//        // 3. setValue kan wel multiplte zijn
//        // 4. forward store to all subitems
//        // 1. getSelection -> [2,4,7]
//        // 2. getSelection -> {state = 'open'}
//        // 3. get all, maar filter -> batch join load
//
//        if (preg_match("/^\[\]$/", $sSubpropertySelector))
//        {
//            /* array with comma separated multiple key support */
//        }
//
//        // 1. regexp voor alles
//        // 2. value voor alles
//
//        if (preg_match("/^\/\/$/", $sSubpropertySelector))
//        {
//            /* regexp */
//        }

//        // init
        $aConditionals = MimotoDataUtils::getConditionals($sPropertySelector);


        // 1. todo - join for batch load


        // 1. todo - haal de conditionals er in de getValue vanaf. Forward is alleen naar subitems, dus forward moet individueel

        error($aConditionals);



        // 1. collection gaat alleen over volgorde en referenties, niet om feitelijk inhoud
        // 2. inhoud draagt eigen changed-status
        // 3. dit houdt het management van de collection vrij eenvoudig


        // 1. maak kopie van $property->data->currentCollection



        // load
        //$entity = $this->loadEntity();

        // forward
        //return (!empty($entity)) ? $entity->getValue($sPropertySelector, $bGetConnectionInfo) : null;
        return '';
    }

    /**
     * Forward setValue request
     * @param $sPropertySelector
     * @param $value
     */
    private function forwardSetValue($sPropertySelector, $value)
    {
        // load
        $entity = $this->loadEntity();

        // forward
        if (!empty($entity)) $entity->setValue($sPropertySelector, $value);
    }

    /**
     * Load entities
     * @param array $aConditionals
     * @return array
     */
    private function loadEntities($aConditionals = null)
    {
        // init
        $aCollection = [];

        // load
        $nCollectionItemCount = count($this->_data->currentCollection);
        for ($nCollectionItemIndex = 0; $nCollectionItemIndex < $nCollectionItemCount; $nCollectionItemIndex++)
        {
            // register
            $connection = $this->_data->currentCollection[$nCollectionItemIndex];

            // verify
            if (empty($connection->getEntity()))
            {
                // load and store
                $connection->setEntity(Mimoto::service('data')->get($connection->getChildEntityTypeName(), $connection->getChildId()));
            }

            // load
            $entity = $connection->getEntity();

            $bVerified = true;
            if (!empty($aConditionals))
            {
                foreach ($aConditionals as $sKey => $value)
                {
                    // verify
                    if ($entity->getValue($sKey) != $value)
                    {
                        $bVerified = false;
                        break;
                    }
                }
            }

            // store
            if ($bVerified) { $aCollection[] = $entity; }
        }

        // send
        return $aCollection;


    }

}
