<?php

// classpath
namespace Mimoto\Session;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * SessionService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SessionService
{

    private $_app;
    private $_currentUser;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($app)
    {
        // store
        $this->_app = $app;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    public function currentUser()
    {
        // 1. do nothing if user not logged in
        if (!$this->_app['session']->get('is_user')) return null;

        // 2. verify
        if (empty($this->_currentUser))
        {
            // 2a. read
            $nUserId = $this->_app['session']->get('user')->id;

            // 2b. load
            $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $nUserId);

            // 2c. do nothing if user does not exist
            if (empty($eUser)) return null;

            // 2d. store
            $this->_currentUser = $eUser;
        }

        // 3. send
        return $this->_currentUser;
    }

}
