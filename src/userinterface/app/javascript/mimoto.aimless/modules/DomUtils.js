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
     * Load wrapper
     */
    loadWrapper: function ($container, sEntityTypeName, nId, sWrapper, sComponent)
    {
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/wrapper/' + sEntityTypeName + '/' + nId + '/' + sWrapper + ((sComponent) ? '/' + sComponent : ''),
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
    
    /**
     * Load wrapper
     */
    updateWrapper: function ($component, sEntityTypeName, nId, sWrapper, sComponent)
    {
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/wrapper/' + sEntityTypeName + '/' + nId + '/' + sWrapper + ((sComponent) ? '/' + sComponent : ''),
            data: null,
            dataType: 'html',
            success: function (data)
            {
                // replace
                $($component).replaceWith(data);
            }
        });
    },
    
    updateComponent: function($component, sEntityTypeName, nId, sTemplate)
    {
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/data/' + sEntityTypeName + '/' + nId + '/' + sTemplate,
            data: null,
            dataType: 'html',
            success: function (data)
            {
                // replace
                $($component).replaceWith(data);
            }
        });
    }
    
    
}
