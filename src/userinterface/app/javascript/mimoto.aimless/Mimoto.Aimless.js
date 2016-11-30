/**
 * Aimless - MLS - Mimoto's Live Screen protocol
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';

module.exports = function(DomService)
{
    // register
    this._DomService = DomService;
    
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
        Mimoto.Aimless.pusher = new Pusher('55152f70c4cec27de21d', {
            cluster: 'eu',
            encrypted: true,
            authEndpoint: '/Mimoto.Aimless/realtime/collaboration'
        });
        
        // init
        var channel = Mimoto.Aimless.pusher.subscribe('Aimless');
        
        // setup listeners
        channel.bind('data.changed', this._DomService.onDataChanged);
        channel.bind('data.created', this._DomService.onDataCreated);
        channel.bind('page.change', this._DomService.onPageChange);
        channel.bind('component.load', this._DomService.onComponentLoad);
        channel.bind('popup.open', this._DomService.onPopupOpen);
    }

}
