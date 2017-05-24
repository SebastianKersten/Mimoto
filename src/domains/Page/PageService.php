<?php

// classpath
namespace Mimoto\Page;

// Mimoto classes
use Mimoto\Mimoto;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * PageService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class PageService
{

    private $_aDataModifications = [];
    private $_sUID = null;
    private $_sTimeStamp = null;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {

    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Handke the user's request
     * @param $response
     * @return JsonResponse
     */
    public function handleRequest()
    {


    }

}
