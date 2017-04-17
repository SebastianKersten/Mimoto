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
        this._aRequests = [];
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load component
     */
    loadComponent: function ($container, sEntityTypeName, nId, sComponentName, sPropertySelector)
    {
        // default
        var sPropertySelector = (!sPropertySelector) ? '' : '/' + sPropertySelector;
    
        // execute
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/data/' + sEntityTypeName + '/' + nId + '/' + sComponentName + sPropertySelector,
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
    loadWrapper: function ($container, sEntityTypeName, nId, sWrapper, sComponentName, sPropertySelector)
    {
        // default
        var sPropertySelector = (!sPropertySelector) ? '' : '/' + sPropertySelector;
        
        // execute
        $.ajax({
            type: 'GET',
            url: '/Mimoto.Aimless/wrapper/' + sEntityTypeName + '/' + nId + '/' + sWrapper + ((sComponentName) ? '/' + sComponent : '') + sPropertySelector,
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
    },
    
    callAPI: function(request)
    {
        $.ajax({
            type: request.type,
            url: request.url,
            data: request.data,
            dataType: request.dataType,
            success: function (resultData, resultStatus, resultSomething)
            {
                //console.error(resultData);
                
                // verify and validate
                if (resultData.dataModifications && resultData.dataModifications instanceof Array)
                {
                    var nModificationCount = resultData.dataModifications.length;
                    for (var nModificationIndex = 0; nModificationIndex < nModificationCount; nModificationIndex++)
                    {
                        // register
                        var dataModification = resultData.dataModifications[nModificationIndex];
                        
                        switch(dataModification.type)
                        {
                            case 'data.created':
    
                                Mimoto.Aimless.dom.onDataCreated(dataModification.data, 'direct');
                                break;
                            
                            case 'data.changed':
    
                                Mimoto.Aimless.dom.onDataChanged(dataModification.data, 'direct');
                                break;
                        }
                    }
                }
                
                // forward
                request.success(resultData.response, resultStatus, resultSomething);
            }
        });
    },
    
    registerRequest: function(sMethod)
    {
        // collect
        var aArguments = [];
        var nArgumentCount = arguments.length;
        for (var nArgumentIndex = 1; nArgumentIndex < nArgumentCount; nArgumentIndex++)
        {
            aArguments.push(arguments[nArgumentIndex]);
        }
        
        // compose
        var request = {
            method: arguments[0],
            aArguments: aArguments
        };
        
        // store
        this._aRequests.push(request);
    },
    
    parseRequestQueue: function()
    {
        // parse
        while (this._aRequests.length > 0)
        {
            // register
            var request = this._aRequests.shift();
            
            // execute
            request.method.apply(Mimoto.form, request.aArguments);
        }
    }
    
}
