/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
let DomUtils = require('./modules/DomUtils');
let DomService = require('./modules/DomService');
let RealtimeManager = require('./modules/RealtimeManager');


/**
 * Class MimotoStartup
 */
module.exports = function()
{
    this.__construct();
};


module.exports.prototype = {


    // private variables
    _realtimeManager: null,



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    // api
    utils: null,
    dom: null,

    // config
    debug: null,
    gateway: null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        // setup
        this.utils = new DomUtils();
        this.dom = new DomService();

        // configure
        this.debug = false;
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Startup Mimoto
     */
    startup: function()
    {
        if (this.debug) console.log('Mimoto starting up ...');

        // update
        MimotoX.utils.parseRequestQueue();

        // logon
        this._realtimeManager = new RealtimeManager(this.gateway);
    },

    /**
     * Listen to data changes
     * @param sPropertySelector
     * @param scope
     * @param fJavascriptDelegate
     */
    listen: function(sPropertySelector, scope, fJavascriptDelegate)
    {
        MimotoX.dom.registerEventListener(sPropertySelector, scope, fJavascriptDelegate);
    }

}
