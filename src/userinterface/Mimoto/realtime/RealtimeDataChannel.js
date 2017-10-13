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
    __construct: function (sSelector)
    {
        // store
        this._sSelector = sSelector;

        console.log('New data channel started .. ', this._sSelector);
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
        this._aClients.push(client);
    },

    /**
     * Disconnect a client from this data channel
     * @param client
     */
    disconnect: function(client)
    {
        // 1. find
        let nClientCount = this._aClients.length;
        for (let nClientIndex = 0; nClientIndex < nClientCount; nClientIndex++)
        {
            // a. verify and delete
            if (this._aClients[nClientIndex]) { this._aClients.splice(nClientIndex, 1); break; }
        }
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
    }

}