/**
 * Mimoto - DataChannel
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';



module.exports = function(sSelector)
{
    // start
    this.__construct(sSelector);
};

module.exports.prototype = {


    _sSelector: null,
    _aDelegates: [],
    _aSendRequests: [],
    _aReceiveRequests: [],



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(sSelector)
    {
        // store
        this._sSelector = sSelector;
    },




    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    connect: function(socket)
    {
        // store
        this._socket = socket;

        // configur
        this._socket.on('dataChannelConnected', function(data) { this._onConnected(data); }.bind(this) );

        // connect
        this._socket.emit('dataChannelConnect', this._sSelector);
    },

    _onConnected: function(data)
    {
        // configure
        this._socket.on('dataChannelReceive', function(message) { this._distributeMessage(message) }.bind(this) );

        // 1. handle queue
        while (this._aSendRequests.length > 0)
        {
            // remove
            let sendRequest = this._aSendRequests.shift();

            // send
            this.send(sendRequest.sEvent, sendRequest.data);
        }
    },

    send: function(sEvent, data)
    {
        // validate or queue
        if (!this._socket)
        {
            this._aSendRequests.push({sEvent:sEvent, data:data});
        }
        else
        {
            // build
            let message = {
                sSelector: this._sSelector,
                sEvent: sEvent,
                data: data
            };

            // broadcast
            this._socket.emit('dataChannelSend', message);
        }
    },

    receive: function(sEvent, fDelegate)
    {
        // verify or init
        if (!this._aDelegates[sEvent]) this._aDelegates[sEvent] = [];

        // store
        this._aDelegates[sEvent].push(fDelegate);
    },

    _distributeMessage: function(message)
    {
        // verify
        if (!this._aDelegates[message.sEvent] || this._aDelegates[message.sEvent].length === 0) return;

        // forward
        let nDelegateCount = this._aDelegates[message.sEvent].length;
        for (let nDelegateIndex = 0; nDelegateIndex < nDelegateCount; nDelegateIndex++)
        {
            // register
            let fDelegate = this._aDelegates[message.sEvent][nDelegateIndex];

            // broadcast
            fDelegate(message.data);
        }
    }

}
