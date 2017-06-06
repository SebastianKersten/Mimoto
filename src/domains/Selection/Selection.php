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
                    case 'type':

                        $this->setType(is_array($selectionSettings) ? $selectionSettings['type'] : $selectionSettings->type);
                        break;

                    case 'id':

                        $this->setId(is_array($selectionSettings) ? $selectionSettings['id'] : $selectionSettings->id);
                        break;

                    case 'property':

                        $this->setProperty(is_array($selectionSettings) ? $selectionSettings['property'] : $selectionSettings->property);
                        break;

                    case 'values':

                        // register
                        $aValues = (is_array($selectionSettings) ? $selectionSettings[$sKey] : $selectionSettings->$sKey);

                        // store
                        foreach ($aValues as $sPropertyName => $valuetoCompare) $this->setValue($sPropertyName, $valuetoCompare);
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
    public function setType($xType)
    {
        // forward
        $this->getAliasRule()->setType($xType);
    }

    /**
     * Set the instance id
     * @param $xId mixed The id
     */
    public function setId($xId)
    {
        // forward
        $this->getAliasRule()->setId($xId);
    }

    /**
     * Set the property containing the entities
     * @param $xParent mixed Reference to the parent property
     */
    public function setProperty($xParent)
    {
        // forward
        $this->getAliasRule()->setProperty($xParent);
    }

    /**
     * Set a rule value (multiple values possible)
     * @param $xValue mixed Reference to the property
     * @param $sValue string The actual value
     */
    public function setValue($xProperty, $sValue)
    {
        $this->getAliasRule()->setValue($xProperty, $sValue);
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
