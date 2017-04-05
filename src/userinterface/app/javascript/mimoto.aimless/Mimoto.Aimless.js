/**
 * Aimless - MLS - Mimoto's Live Screen protocol
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

module.exports = function(DomService)
{
    // start
    this.__construct();
};

module.exports.prototype = {


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function ()
    {

    },


    // ----------------------------------------------------------------------------
    // --- Public methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Create new entity
     */
    connect: function (sAuthKey, sCluster, sHost, bEncrypted, sAuthEndPoint, bDebugMode)
    {
        if (bDebugMode === true) {
            // Enable pusher logging - don't include this in production
            Pusher.log = function (message) {
                if (window.console && window.console.log) {
                    window.console.log(message);
                }
            };
        }
        
        try {
            // connect
            Mimoto.Aimless.pusher = new Pusher(sAuthKey, {
                cluster: sCluster,
                host: sHost,
                encrypted: bEncrypted,
                authEndpoint: sAuthEndPoint
            });
    
            // init
            var channel = Mimoto.Aimless.pusher.subscribe('Aimless');
    
            // setup listeners
            channel.bind('data.changed', Mimoto.Aimless.dom.onDataChanged);
            channel.bind('data.created', Mimoto.Aimless.dom.onDataCreated);
            channel.bind('page.change', Mimoto.Aimless.dom.onPageChange);
            channel.bind('component.load', Mimoto.Aimless.dom.onComponentLoad);
            channel.bind('popup.open', Mimoto.Aimless.dom.onPopupOpen);
        }
        catch(e)
        {
            console.log('Pusher says oops! (might have something to do with something like Privacy Badger)');
        }
    },

    listen: function(sPropertySelector, scope, fJavascriptDelegate)
    {
        Mimoto.Aimless.dom.registerEventListener(sPropertySelector, scope, fJavascriptDelegate);
    }

}
