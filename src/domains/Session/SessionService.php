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

    public function createPasswordHash($sPassword)
    {
        // 1. skip if object passed (result of an empty password value) instead of a new password string
        if (is_object($sPassword)) return $sPassword;

        // 2. init
        $encryptedPassword = (object) array(
            'salt' => bin2hex(random_bytes(32)),
            'iterations' => 50000
        );

        // 3. encrypt
        $encryptedPassword->hash = hash_pbkdf2('sha256', $sPassword, $encryptedPassword->salt, $encryptedPassword->iterations, 64);

        // 4. send
        return $encryptedPassword;
    }

    public function comparePassword($sPassword, $encryptedPassword)
    {
        // 1. validate
        if (!isset($encryptedPassword->hash) || empty($encryptedPassword->hash)) return false;
        if (!isset($encryptedPassword->salt) || empty($encryptedPassword->salt)) return false;
        if (!isset($encryptedPassword->iterations) || empty($encryptedPassword->iterations)) return false;

        // 2. compare
        return ($encryptedPassword->hash == hash_pbkdf2('sha256', $sPassword, $encryptedPassword->salt, $encryptedPassword->iterations, 64));
    }


    public static function sendMagicLink($eUser)
    {
        // 1. load previously active links
        $aMagicLinks = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_MAGICLINK, 'values' => ['userId' => $eUser->getId(), 'isActive' => true]]);

        // 2. disable
        $nLinkCount = count($aMagicLinks);
        for ($nLinkIndex = 0; $nLinkIndex < $nLinkCount; $nLinkIndex++)
        {
            // a. register
            $eMagicLink = $aMagicLinks[$nLinkIndex];

            // b. update
            $eMagicLink->set('isActive', false);

            // c. store
            Mimoto::service('data')->store($eMagicLink);
        }


        // ---


        // 3. create
        $sHash = bin2hex(random_bytes(32));

        // 4. init
        $eMagicLink = Mimoto::service('data')->create(CoreConfig::MIMOTO_MAGICLINK);

        // 5. setup
        $eMagicLink->set('hash', $sHash);
        $eMagicLink->set('expiryDate', date('Y-m-d H:i:s', mktime(date('H'), date('i') + 10, date('s'), date('m'), date('d'), date('Y'))));
        $eMagicLink->set('isActive', true);
        $eMagicLink->set('userId', $eUser->getId());

        // 6. store
        Mimoto::service('data')->store($eMagicLink);


        // ---


        // 7. determine
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

        // 8. build
        $sURL = $protocol.$_SERVER['HTTP_HOST'].'/login/'.$sHash;

        // 9. send
        return $sURL;
    }
}
