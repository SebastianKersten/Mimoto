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


    public function get($sSelector)
    {
        // 1. split
        $aSelectorParts = explode('.', $sSelector);

        // 2. init
        $value = null;

        // 3. find
        $nPartCount = count($aSelectorParts);
        for ($nPartIndex = 0; $nPartIndex < $nPartCount; $nPartIndex++)
        {
            // recursive
        }

        // 4. send
        return '';
    }


}
