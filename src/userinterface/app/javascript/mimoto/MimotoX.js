/**
 * Aimless - MLS - Mimoto's Live Screen protocol
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
var DomUtils = require('./mimoto/modules/DomUtils');
var RealtimeManager = require('./modules/RealtimeManager');



module.exports = function()
{
    // start
    this.__construct();
};

module.exports.prototype = {


    // services
    _realtimeManager: null,
    _utils : null,


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function ()
    {
        // connect
        this._realtimeManager = new RealtimeManager();
        this._utils = new DomUtils();
    },


    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    utils: function()
    {
        return this._utils;
    }

}
