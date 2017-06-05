<?php

// classpath
namespace Mimoto\Selection;


/**
 * Selection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Selection
{
    // properties
    private $_sName = '';

    // instructions
    private $_bAllowDuplicates = false;

    // rules
    private $_aRules = [];
    private $_aliasRule = null;



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param null $selectionSettings mixed Object or array containing the selection settings
     */
    public function __construct($selectionSettings = null)
    {
        // validate
        if (!empty($selectionSettings))
        {
            // convert
            foreach ($selectionSettings as $sKey => $value)
            {
                switch($sKey)
                {
                    case 'entityType':

                        $this->setEntityType(is_array($selectionSettings) ? $selectionSettings['entityType'] : $selectionSettings->entityType);
                        break;

                    case 'instanceId':

                        $this->setInstanceId(is_array($selectionSettings) ? $selectionSettings['insgtanceId'] : $selectionSettings->instanceId);
                        break;

                    case 'parentProperty':

                        $this->setParentProperty(is_array($selectionSettings) ? $selectionSettings['parentProperty'] : $selectionSettings->parentProperty);
                        break;

                    case 'propertyValues':

                        // register
                        $aValues = (is_array($selectionSettings) ? $selectionSettings[$sKey] : $selectionSettings->$sKey);

                        foreach ($aValues as $sPropertyName => $valuetoCompare)
                        {
                            $this->setPropertyValue($sPropertyName, $valuetoCompare);
                        }
                        break;
                }

            }
        }
    }



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get the selection name
     * @return string The name of the selection
     */
    public function getName()
    {
        // load and send
        return $this->_sName;
    }

    /**
     * Set the selection name
     * @param $sValue string The name of the selection
     */
    public function setName($sValue)
    {
        // store
        $this->_sName = $sValue;
    }


    /**
     * Check if the selection allows duplicate entires
     * @return boolean If false, duplicates are filtered from the result
     */
    public function getAllowDuplicates()
    {
        // load and send
        return $this->_bAllowDuplicates;
    }

    /**
     * Define if the selection accept duplicate entries
     * @param $bValue boolean The name of the selection
     */
    public function setAllowDuplicates($bValue = false)
    {
        // store
        $this->_bAllowDuplicates = $bValue;
    }


    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Add a rule to the selection
     * @return SelectionRule
     */
    public function addRule()
    {
        // init
        $rule = new SelectionRule();

        // store
        $this->_aRules[] = $rule;

        // send
        return $rule;
    }

    /**
     * Get all the rules within this selection
     * @return array
     */
    public function getRules()
    {
        // send
        return $this->_aRules;
    }



    // ----------------------------------------------------------------------------
    // --- Public aliasses --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set the entity type
     * @param $xType mixed Reference to the entity type
     */
    public function setEntityType($xType)
    {
        // forward
        $this->getAliasRule()->setEntityType($xType);
    }

    /**
     * Set the instance id
     * @param $xId mixed The id
     */
    public function setInstanceId($xId)
    {
        // forward
        $this->getAliasRule()->setInstanceId($xId);
    }

    /**
     * Set the parent property
     * @param $xParent mixed Reference to the parent property
     */
    public function setParentProperty($xParent)
    {
        // forward
        $this->getAliasRule()->setParentProperty($xParent);
    }

    /**
     * Set a rule value (multiple values possible)
     * @param $xValue mixed Reference to the property
     * @param $sValue string The actual value
     */
    public function setPropertyValue($xProperty, $sValue)
    {
        $this->getAliasRule()->setPropertyValue($xProperty, $sValue);
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get alias rule
     * @return SelectionRule
     */
    private function getAliasRule()
    {
        // verify
        if (empty($this->_aliasRule))
        {
            // init and register
            $this->_aliasRule = $this->addRule();
        }

        // send
        return $this->_aliasRule;
    }

}
