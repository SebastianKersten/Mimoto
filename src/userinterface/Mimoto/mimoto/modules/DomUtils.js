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
    loadComponent: function (container, sEntityTypeName, nEntityId, sComponentName, sPropertySelector, nConnectionId)
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

                    // add to dom
                    container.append(element);

                    // register directives
                    Mimoto.display.parseInterface(element.parentNode);
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

    updateComponent: function(elementToReplace, sEntitySelector, sComponentName, nConnectionId)
    {
        // #todo - FIX
        if (!elementToReplace) return;



        // splite
        let aEntitySelectorElements = sEntitySelector.split('.');

        // compose
        let requestData = {
            sEntityTypeName: aEntitySelectorElements[0],
            nEntityId: aEntitySelectorElements[1],
            sComponentName: sComponentName,
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

                    // get parent
                    let container = elementToReplace.parentNode;

                    // add new
                    container.insertBefore(element, elementToReplace);

                    // remove old
                    Mimoto.utils.removeComponent(elementToReplace);

                    // register directives
                    Mimoto.display.parseInterface(element.parentNode);
                }
            }
        };

        // prepare
        request.open('post', '/mimoto/output/component', true);


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

    removeComponent: function(element)
    {
        // filter wrong usage
        if (!element) return;

        // cleanup
        Mimoto.display.cleanupDirectives(element);

        // remove
        element.parentNode.removeChild(element);
    },


    callAPI: function(apiRequest)
    {
        // compose
        let requestData = apiRequest.data;

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
                    let response = JSON.parse(request.responseText);

                    // verify and validate
                    if (response.dataModifications && response.dataModifications instanceof Array)
                    {
                        var nModificationCount = response.dataModifications.length;
                        for (var nModificationIndex = 0; nModificationIndex < nModificationCount; nModificationIndex++)
                        {
                            // register
                            var dataModification = response.dataModifications[nModificationIndex];

                            switch(dataModification.type)
                            {
                                case 'data.created':

                                    //Mimoto.dom.onDataCreated(dataModification.data, 'direct');
                                    break;

                                case 'data.changed':

                                    Mimoto.dom.onDataChanged(dataModification.data, 'direct');
                                    break;
                            }
                        }
                    }

                    // forward
                    apiRequest.success(response.response, response.status, response.statusText);
                }
            }
        };

        // prepare
        request.open(apiRequest.type || 'get', apiRequest.url, true);


        // setup
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // prepare
        let sRequestData = '';
        for (let sKey in requestData)
        {
            if (requestData[sKey])
            {
                if (sRequestData.length !== 0) sRequestData += '&';

                // register
                let value = requestData[sKey];

                // convert
                if (typeof value === 'object') value = JSON.stringify(value);

                // compose
                sRequestData += sKey + '=' + value;
            }
        }

        // send
        request.send(sRequestData);
    }
    
}
