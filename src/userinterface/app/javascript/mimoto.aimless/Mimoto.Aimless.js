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
    connect: function (bDebugMode)
    {
        if (bDebugMode === true) {
            // Enable pusher logging - don't include this in production
            Pusher.log = function (message) {
                if (window.console && window.console.log) {
                    window.console.log(message);
                }
            };
        }

        // connect
        Mimoto.Aimless.pusher = new Pusher('19c5b7fbb5340fe48402', {
            cluster: 'eu',
            host: 'api-eu.pusher.com',
            encrypted: true,
            authEndpoint: '/Mimoto.Aimless/realtime/collaboration'
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

}
