/**
 * Mimoto - A realtime fluid data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
var DomUtils = require('./DomUtils');
var RealtimeManager = require('./RealtimeManager');


/**
 * Class MimotoStartup
 */
module.exports = function()
{
    this.__construct();
};


module.exports.prototype = {


    // setup
    _utils: null,
    _realtimeManager: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {

        console.log('MimotoX connected.');


        // setup
        this._utils = new DomUtils();

        // logon
        this._realtimeManager = new RealtimeManager();
    },

    connect: function()
    {
        console.warn('Connect handshake!');
    },

    utils: function()
    {
        return this._utils;
    }
}
