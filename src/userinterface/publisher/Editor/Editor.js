/**
 * Mimoto.Publisher - Demo - How to build a publication platform
 *
 * @author Sebastian Kersten (@supertaboo)
 */


'use strict';



module.exports = function() {


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
    __construct: function()
    {

    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    onInfocardAdd: function(NodeConfig)
    {
        console.log('Hi! from custom publisher onAdd function');

        // 1. check if id is set
        // 2. call popup, or
        // 3. create comment

        //let my_blot = Parchment.find(NodeConfig.node);


        //let popup = MimotoX.popup('/Mimoto.Aimless/form/infocard');
    },

    onInfocardEdit: function(NodeConfig)
    {
        console.log('Hi! from custom publisher onEdit function');

        // 1. check if id is set
        // 2. call popup, or
        // 3. create comment

        let popup = MimotoX.popup('/Mimoto.Aimless/form/infocard');

        // 4. delete formatting options (als mogelijke feedback van popup)
        // 5. onInit (wanneer het op de dom geplaatst worden vanuit een saved state
    }

};
