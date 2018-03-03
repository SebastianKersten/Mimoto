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
    private $_sPathToConfigFile = '';


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($sPathToConfigFile)
    {
        // store
        $this->_sPathToConfigFile = $sPathToConfigFile;

        // load
        $this->loadConfigFile();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function get()
    {

    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    /**
     * Load config file
     */
    private function loadConfigFile()
    {
        $sConfigFile = dirname(__FILE__).((substr($this->_sPathToConfigFile, 0, 1) == '/') ? '' : '/').$this->_sPathToConfigFile;
        if (file_exists($sConfigFile))
        {
            $config = include($sConfigFile);
        }
        else
        {
            echo "
                <h1>Installing Mimoto (step 1 / 2)</h1>
                <ol>
                    <li>Make a copy of `config.php.dist` and name it `config.php`</li>
                    <li>Add your MySQL credentials to your `config.php`</li>
                    <li>Import the database dump in `/database` in your MySQL</li>
                </ol>";
            die();
        }
    }

}
