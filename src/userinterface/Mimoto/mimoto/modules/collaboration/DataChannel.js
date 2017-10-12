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
    _queuedIdentificationData: null,

    // users
    _self: null,
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
        // validate or queue
        if (!this._socket)
        {
            this._queuedIdentificationData = publicData;
        }
        else
        {
            this._socket.emit('dataChannelIdentify', this._sSelector, publicData);
        }
    },

    getInfo: function(clientId)
    {
        return (this._aOthers[clientId]) ? this._aOthers[clientId].publicData : null;
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



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _connect: function(socket)
    {
        // 1. skip reconfiguration
        if (this._socket) return;

        // 2. store
        this._socket = socket;

        // 3. configure
        this._socket.on('dataChannelSelfConnected', function(data) { this._onSelfConnected(data); }.bind(this) );
        this._socket.on('dataChannelOtherConnected', function(data) { this._onOtherConnected(data); }.bind(this) );
        this._socket.on('dataChannelOtherIdentified', function(clientId, publicData) { this._onOtherIdentified(clientId, publicData); }.bind(this) );
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

        // 3. filter
        let aOtherIds = [];
        for (let clientId in this._aOthers) aOtherIds.push(clientId);

        // 4. let `self` know
        if (this.onSelfConnected && typeof this.onSelfConnected === "function") this.onSelfConnected(aOtherIds);

        // 5. handle identification queue
        if (this._queuedIdentificationData)
        {
            // a. execute
            this.identify(this._queuedIdentificationData);

            // b. cleanup
            delete this._queuedIdentificationData;
        }

        // 6. handle send queue
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
        this._aOthers[clientId] = { clientId: clientId };

        // 2. report newly connected user
        if (this.onOtherConnected && typeof this.onOtherConnected === "function") this.onOtherConnected(clientId);
    },

    _onOtherIdentified: function(clientId, publicData)
    {
        // 1. store
        if (this._aOthers[clientId]) this._aOthers[clientId].publicData = publicData;

        // 2. report newly identification
        if (this.onOtherIdentified && typeof this.onOtherIdentified === "function") this.onOtherIdentified(clientId);
    },

    _onOtherDisconnected: function(clientId)
    {
        // 1. cleanup
        if (this._aOthers[clientId]) delete this._aOthers[clientId];

        // 2. report recently disconnected user
        if (this.onOtherDisconnected && typeof this.onOtherDisconnected === "function") this.onOtherDisconnected(clientId);
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
