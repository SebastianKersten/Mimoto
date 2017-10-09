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
    _aOthers: [],


    DATACHANNEL_EVENT_PREFIX: 'Mimoto_DataChannelEvent',



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
    // --- Events -----------------------------------------------------------------
    // ----------------------------------------------------------------------------


    onSelfConnected: null,
    onOtherConnected: null,
    onOtherDisconnected: null,



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    identify: function(publicData)
    {
        // register user information which is publicly broadcasted within the channel

        // 1. broadcast
        // 2. make available
    },

    connect: function(socket)
    {
        // 1. skip reconfiguration
        if (this._socket) return;

        // 2. store
        this._socket = socket;

        // 3. configure
        this._socket.on('dataChannelSelfConnected', function(data) { this._onSelfConnected(data); }.bind(this) );
        this._socket.on('dataChannelOtherConnected', function(data) { this._onOtherConnected(data); }.bind(this) );
        this._socket.on('dataChannelOtherDisconnected', function(data) { this._onOtherDisconnected(data); }.bind(this) );

        // 4. connect
        this._socket.emit('dataChannelConnect', this._sSelector);
    },

    _onSelfConnected: function(others)
    {
        // 1. register users here
        this._aOthers = others;

        // 2. configure
        this._socket.on('dataChannelReceive', function(message, clientId) { this._distributeMessage(message, clientId) }.bind(this) );

        // 3. let `self` know
        if (this.onConnected && typeof this.onConnected === "function") this.onConnected();

        // 4. handle queue
        while (this._aSendRequests.length > 0)
        {
            // a. remove
            let sendRequest = this._aSendRequests.shift();

            // b. send
            this.send(sendRequest.sEvent, sendRequest.data);
        }
    },

    _onOtherConnected: function(clientId)
    {
        // 1. store
        this._aOthers.push(clientId);

        // 2. report newly connected user
        if (this.onOtherConnected && typeof this.onOtherConnected === "function") this.onOtherConnected(clientId);
    },

    _onOtherDisconnected: function(clientId)
    {
        // 1. cleanup
        for (let nOtherIndex = 0; nOtherIndex < this._aOthers.length; nOtherIndex++)
        {
            // a. remove
            this._aOthers.splice(nOtherIndex, 1);

            // b. update
            nOtherIndex--;
        }

        // 2. report recently disconnected user
        if (this.onOtherDisconnected && typeof this.onOtherDisconnected === "function") this.onOtherDisconnected(clientId);
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
        if (!this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + sEvent]) this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + sEvent] = [];

        // store
        this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + sEvent].push(fDelegate);
    },

    _distributeMessage: function(message, clientId)
    {
        // verify
        if (!this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + message.sEvent] || this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + message.sEvent].length === 0) return;

        // forward
        let nDelegateCount = this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + message.sEvent].length;
        for (let nDelegateIndex = 0; nDelegateIndex < nDelegateCount; nDelegateIndex++)
        {
            // register
            let fDelegate = this._aDelegates[this.DATACHANNEL_EVENT_PREFIX + message.sEvent][nDelegateIndex];

            // broadcast
            fDelegate(message.data, clientId);
        }
    }

}
