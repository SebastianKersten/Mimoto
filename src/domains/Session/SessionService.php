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
    const PASSWORD_HASH_ALGORITM = PASSWORD_BCRYPT;
    const PASSWORD_HASH_OPTIONS = [
        'cost' => PASSWORD_BCRYPT_DEFAULT_COST + 1, // be on the safe side
    ];

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

    public function createPasswordHash($sPassword)
    {
        // encrypt
        $encryptedPassword = password_hash($sPassword, self::PASSWORD_HASH_ALGORITM, self::PASSWORD_HASH_OPTIONS);

        // validate
        if (empty($encryptedPassword)) {
            throw new \Exception('can not properly hash password');
        }

        // send
        return $encryptedPassword;
    }

    public function comparePassword($sPassword, $encryptedPassword)
    {
        return password_verify($sPassword, $encryptedPassword);
    }
}
