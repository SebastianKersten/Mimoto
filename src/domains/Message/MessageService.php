<?php

// classpath
namespace Mimoto\Message;

// Mimoto classes
use Mimoto\Mimoto;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * MessageService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MessageService
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
        // 1. get message id
        // 2. centraal opslaan als UID
        // 3. verzamel changes for broadcast
        // 4. create UID
        // 5. send in response
        // 6. js check message id
        // 7. if parsed, skip

    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Build a Mimoto response
     * @param $response
     * @return JsonResponse
     */
    public function response($data, $nResultcode = 200)
    {
        // compose and send
        return new JsonResponse(
            (object) array(
                'response' => $data,
                'dataModifications' => $this->_aDataModifications
            ),
            $nResultcode
        );
    }



    // ----------------------------------------------------------------------------
    // --- Internal public methods ------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Register a data modification
     * @param $sEvent Type of modifications
     * @param $data The modified data
     */
    public function registerModification($sEvent, $data)
    {
        // register
        $this->_aDataModifications[] = (object) array(
            'type' => $sEvent,
            'data' => $data
        );
    }


    /**
     * Get Unique Message Identifier
     */
    public function getMessageUID()
    {
        // verify
        if (empty($this->_sUID))
        {
            // toggle between cache or database
            if (Mimoto::service('cache')->isEnabled())
            {
                // load
                $xUID = Mimoto::service('cache')->getValue('mimoto.global.message.uid');

                // default
                if (empty($xUID)) $xUID = 0;

                // update
                $xUID++;

                // store
                Mimoto::service('cache')->setValue('mimoto.global.message.uid', $xUID);
            }
            else
            {
                $xUID = date('YmdHis');
            }

            // convert
            $this->_sUID = md5($xUID . Mimoto::service('user')->getUserId());
            $this->_sTimeStamp = date('YmdHis');;
        }

        // send
        return (object) array(
            'uid' => $this->_sUID,
            'timestamp' => $this->_sTimeStamp
        );
    }
}
