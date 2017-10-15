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

    _aClients: [],


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


    /**
     * Connect a client to this data channel
     * @param client
     */
    connect: function(client)
    {
        // 1. store
        this._aClients[client.id] = { client:client, publicData:null };

        // 2. join room
        client.join(this._getRoomName());

        // 3. let the others know about the new client
        client.broadcast.to(this._getRoomName()).emit(this._composeEvent('dataChannelOtherConnected'), client.id);

        // 4. configure
        client.on(this._composeEvent('dataChannelIdentify'), function(publicData) { this._onIdentify(client, publicData); }.bind(this));
        client.on(this._composeEvent('dataChannelSend'), function(message) { this._onSend(client, message); }.bind(this));


        console.log('Connect', this._aClients);

        // 4. collect others
        let aOthers = {};
        for (let otherId in this._aClients)
        {
            // a. skip current client
            if (otherId === client.id) continue;

            // b. register
            aOthers[otherId] = {
                clientId: otherId,
                publicData: this._aClients[otherId].publicData
            };
        }

        console.log('aOthers', aOthers);


        // 5. send handshake
        client.emit(this._composeEvent('dataChannelSelfConnected'), aOthers);
    },

    /**
     * Disconnect a client from this data channel
     * @param client
     */
    disconnect: function(client)
    {
        // 1. broadcast disconnect to all others
        client.broadcast.to(this._getRoomName()).emit(this._composeEvent('dataChannelOtherDisconnected'), client.id);

        // 2. cleanup
        delete this._aClients[client.id];
    },



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Check if data channel is empty
     * @returns {boolean}
     */
    isEmpty: function()
    {
        return this._aClients.length === 0;
    },

    /**
     * Get data channel's selector
     * @returns string
     */
    getSelector: function()
    {
        return this._sSelector;
    },



    // ----------------------------------------------------------------------------
    // --- Event listeners --------------------------------------------------------
    // ----------------------------------------------------------------------------



    _onIdentify: function(client, publicData)
    {
        //console.log('onIdentify -----------> [' + client.id + '] identifies on [' + this._sSelector+ '] with', publicData);


        console.log('\n----------\nthis._aClients.onIdentify', this._aClients, '\n----------\n');


        // 1. load
        let clientInfo = this._aClients[client.id];

        // 2. validate
        if (!clientInfo) return;

        // 3. store
        clientInfo.publicData = publicData;

        //console.log('publicData', publicData);

        // 4. broadcast new information
        client.broadcast.to(this._getRoomName()).emit(this._composeEvent('dataChannelOtherIdentified'), client.id, publicData);
    },


    _onSend: function(client, message)
    {
        // 1. broadcast message
        client.broadcast.to(this._getRoomName()).emit(this._composeEvent('dataChannelReceive'), client.id, message);
    },



    // ----------------------------------------------------------------------------
    // --- Utils ------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Compose a channel-unique event name
     * @param sEvent string The name of the event
     * @returns {string}
     * @private
     */
    _composeEvent: function(sEvent)
    {
        return sEvent + '-' + this._sSelector;
    },

    /**
     * Compose the channel's room name
     * @returns {string}
     * @private
     */
    _getRoomName: function()
    {
        return 'dataChannel-' + this._sSelector;
    }

}