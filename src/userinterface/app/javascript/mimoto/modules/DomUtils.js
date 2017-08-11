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
     * Load component NEW
     */
    loadComponentNEW: function (container, sEntityTypeName, nEntityId, sComponentName, sPropertySelector, nConnectionId)
    {
        // compose
        let requestData = {
            sEntityTypeName: sEntityTypeName,
            nEntityId: nEntityId,
            sComponentName: sComponentName,
            sWrapperName: null,
            sPropertySelector: sPropertySelector,
            nConnectionId: nConnectionId
        };


        // init
        let request = new XMLHttpRequest();

        // setup
        request.onreadystatechange = function()
        {
            if(request.readyState === 4)
            {
                if(request.status === 200)
                {

                    // convert
                    //var response = JSON.parse(request.responseText);
                    let response = request.responseText;

                    // init
                    let parser = new DOMParser();
                    let newDocument = parser.parseFromString(response, "text/html");

                    // isolate
                    let element = newDocument.querySelector('body').firstChild;

                    // register directives
                    MimotoX.display.parseInterface(newDocument.querySelector('body'));

                    // add to dom
                    container.append(element);
                }
            }
        };

        // prepare
        request.open('post', '/mimoto.data/render', true);

        // setup
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


        // prepare
        let sRequestData = '';
        for (let sKey in requestData)
        {
            if (requestData[sKey])
            {
                if (sRequestData.length !== 0) sRequestData += '&';
                sRequestData += sKey + '=' + requestData[sKey];
            }
        }

        // send
        request.send(sRequestData);
    },

    /**
     * Load wrapper NEW
     */
    loadWrapperNEW: function ($container, sEntityTypeName, nId, sWrapperName, sComponentName, sPropertySelector, nConnectionId)
    {
        // compose
        let data = {
            sEntityTypeName: sEntityTypeName,
            sEntityId: nEntityId,
            sComponentName: sComponentName,
            sWrapperName: sWrapperName,
            sPropertySelector: sPropertySelector,
            nConnectionId: nConnectionId
        };

        // execute
        $.ajax({
            type: 'POST',
            url: '/mimoto.data/render',
            data: data,
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

                                //MimotoX.dom.onDataCreated(dataModification.data, 'direct');
                                break;

                            case 'data.changed':

                                MimotoX.dom.onDataChanged(dataModification.data, 'direct');
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
