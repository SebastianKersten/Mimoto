<?php

// classpath
namespace Mimoto\Config;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * ConfigService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ConfigService
{

    // config
    private $_config = '';


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($config)
    {
        // store
        $this->_config = $config;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get value from node
     * @param $sSelector
     */
    public function get($sSelector)
    {
        // 1. split
        $aSelectorParts = explode('.', $sSelector);

        // 2. read and send
        return $this->getNode($this->_config, $aSelectorParts);;
    }



    // ----------------------------------------------------------------------------
    // --- private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    private function getNode($root, $aSelectorParts)
    {
        // 1. read and remove
        $sSelectorPart = array_shift($aSelectorParts);

        // 2. verify and read
        if (!is_array($root) && isset($root->$sSelectorPart))
        {
            $nodeValue = $root->$sSelectorPart;
        }
        else if (is_array($root) && isset($root[$sSelectorPart]))
        {
            $nodeValue = $root[$sSelectorPart];
        }
        else
        {
            return null;
        }

        // 3. load
        if (count($aSelectorParts) > 0)
        {
            // b.
            return $this->getNode($nodeValue, $aSelectorParts);
        }
        else
        {
            return $nodeValue;
        }
    }

}
