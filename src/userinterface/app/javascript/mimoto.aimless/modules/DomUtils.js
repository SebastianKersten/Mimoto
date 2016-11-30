/**
 * Mimoto.CMS - Form handling
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


    /**
     * Load component
     */
    loadComponent: function ($container, sEntityTypeName, nId, sTemplate)
    {
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/data/' + sEntityTypeName + '/' + nId + '/' + sTemplate,
            data: null,
            dataType: 'html',
            success: function (data) {
                $($container).append(data);
            }
        });
    },
    
    /**
     * Load entity
     */
    loadEntity: function ($container, sEntityTypeName, nId, sTemplate)
    {
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/data/' + sEntityTypeName + '/' + nId + '/' + sTemplate,
            data: null,
            dataType: 'html',
            success: function (data) {
    
                // delete
                $($container).empty();
                
                // output
                $($container).append(data);
            }
        });
    },
    
    updateComponent: function(ajax, dom)
    {
        
    }
    
    
}
