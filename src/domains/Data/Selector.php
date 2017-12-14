<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * Selector
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Selector
{

    /**
     * The original selector vlaue
     * @var string
     */
    private $_sSelector;

    // selector
    const SELECTOR_KEY_SEPARATOR = '.';
    const SELECTOR_ARRAY_START = '[';
    const SELECTOR_ARRAY_END = ']';
    const SELECTOR_EXPRESSION_START = '{';
    const SELECTOR_EXPRESSION_END = '}';
    const SELECTOR_EXPRESSION_SEPERATOR = '=';



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param string $sSelector
     */
    public function __construct($sSelector)
    {
        // 1. store
        $this->_sSelector = $sSelector;

        // 2. locate
        $nSeparatorPos = strpos($sSelector, self::SELECTOR_KEY_SEPARATOR);
        $nIndexPos = strpos($sSelector, self::SELECTOR_ARRAY_START);
        $nExpressionPos = strpos($sSelector, self::SELECTOR_EXPRESSION_START);

        if ($nSeparatorPos !== false)
        {
            if ($nIndexPos !== false && $nSeparatorPos < $nIndexPos || $nExpressionPos !== false && $nSeparatorPos < $nExpressionPos)

                // a. []

                // first next .
                // check next element -> [] or {}
        }


        // a. check correct chars




        Mimoto::error($nSeparatorPos);


        Mimoto::error($sSelector);

        // strip
        $sSubpropertySelector = substr($sPropertySelector, strlen($property->getName()));

        // strip more
        if (substr($sSubpropertySelector, 0, 1) === '.') { $sSubpropertySelector = substr($sSubpropertySelector, 1); }

        // send
        return $sSubSelector;


//        check for [] and {}
//
//
//        $n
//        $this->_aSubselectors =
//
//        get current
//        store subparts
//
//
//        store parts
//
//        ambassador.managers.[first3].email
//
//
//        hasIndex <- only for current propertyName
//
//        hasExpression (= Selection)
//
//
//        subproperties
//        $this->_sPropertyNAme
//
//
//
//            getSubselector() string

        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - setup -------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity's property names
     * @return array
     */
    public function getPropertyNames()
    {

    }
    
}
