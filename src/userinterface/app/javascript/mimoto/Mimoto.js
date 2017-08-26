/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
let DomUtils = require('./modules/DomUtils');
let DomService = require('./modules/DomService');
let DataService = require('./modules/data/DataService');
let DisplayService = require('./modules/display/DisplayService');
let RealtimeManager = require('./modules/RealtimeManager');


/**
 * Class MimotoStartup
 */
module.exports = function()
{
    this.__construct();
};


module.exports.prototype = {


    // private variables
    _realtimeManager: null,



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    // api
    utils: null,
    dom: null,
    data: null,
    display: null,

    // config
    autoLogon: null,
    debug: null,
    autoloadCSS: null,
    gateway: null,

    // caching
    version: null,

    // project
    projectName: 'mimoto',


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function()
    {
        // setup
        this.utils = new DomUtils();
        this.dom = new DomService();

        // configure
        this.autoLogon = true;
        this.debug = false;
        this.autoloadCSS = true;
        this.version = '';
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Startup Mimoto
     */
    startup: function()
    {
        if (this.debug) console.log('Mimoto starting up ...');

        // parse interface
        this.data = new DataService();
        this.display = new DisplayService();


        // update
        MimotoX.utils.parseRequestQueue();

        // logon
        if (this.autoLogon) this._realtimeManager = new RealtimeManager(this.gateway);
    },

    /**
     * Listen to data changes
     * @param sPropertySelector
     * @param scope
     * @param fJavascriptDelegate
     */
    listen: function(sPropertySelector, scope, fJavascriptDelegate)
    {
        MimotoX.dom.registerEventListener(sPropertySelector, scope, fJavascriptDelegate);
    },

    popup: function(sURL, postData, bLoadInIFrame)
    {

        if (!document.getElementById('MimotoCMS'))
        {

            if (this.autoloadCSS)
            {
                var head = document.head;
                var link = document.createElement('link');

                link.type = 'text/css';
                link.rel = 'stylesheet';
                link.href = '/mimoto/static/css/mimoto.cms.css';

                head.appendChild(link);
            }


            var rootElement = document.createElement('div');
            rootElement.setAttribute('id', 'MimotoCMS');

            // var applicationLayer = document.createElement('div');
            // applicationLayer.setAttribute('id', 'mimoto_layer_application');
            // rootElement.appendChild(applicationLayer);

            var overlayLayer = document.createElement('div');
            overlayLayer.setAttribute('id', 'Mimoto_layer_overlay');
            overlayLayer.setAttribute('class', 'MimotoCMS_layer_overlay MimotoCMS_hidden');
            rootElement.appendChild(overlayLayer);

            var popupLayer = document.createElement('div');
            popupLayer.setAttribute('id', 'Mimoto_layer_popup');
            popupLayer.setAttribute('class', 'MimotoCMS_layer_popup MimotoCMS_hidden');
            rootElement.appendChild(popupLayer);

            var popup = document.createElement('div');
            popup.setAttribute('id', 'popup');
            popup.setAttribute('class', 'MimotoCMS_interface_Popup');


            popupLayer.appendChild(popup);

            var closeButtonElement = document.createElement('div');
            closeButtonElement.setAttribute('class', 'MimotoCMS_interface_Popup__closebutton');
            closeButtonElement.setAttribute('onclick', 'MimotoX.closePopup();');

            var closeButtonLabel = document.createTextNode('Close');
            closeButtonElement.appendChild(closeButtonLabel);


            var contentElement = document.createElement('div');
            contentElement.setAttribute('id', 'Mimoto_popup_content');
            contentElement.setAttribute('class', 'MimotoCMS_interface_Popup__content');

            popup.appendChild(closeButtonElement);
            popup.appendChild(contentElement);

            document.body.appendChild(rootElement);
        }


        // lock background from scrolling
        document.body.classList.add("MimotoCMS_layer_application");


        // register
        let layer_overlay = document.getElementById('Mimoto_layer_overlay');
        let layer_popup = document.getElementById('Mimoto_layer_popup');
        let popup_content = document.getElementById('Mimoto_popup_content');

        // show
        layer_overlay.classList.remove('MimotoCMS_hidden');
        layer_popup.classList.remove('MimotoCMS_hidden');





        // $.ajax({
        //     url: sURL,
        //     dataType: 'html',
        //     method: (postData) ? 'post' : 'get',
        //     data: postData,
        //     success: function(data, textStatus, jqXHR) {
        //
        //         //jQuery(selecteur).html(jqXHR.responseText);
        //         var response = jQuery(jqXHR.responseText);
        //         //var responseScript = response.filter("script");
        //         //jQuery.each(responseScript, function(idx, val) { eval(val.text); } );
        //
        //         //popup_content.innerHTML = reponse;
        //         $('#Mimoto_popup_content').html(data);
        //
        //         /*// focus primary input
        //          var primaryInput = document.getElementById('form_field_name');
        //          if (primaryInput)
        //          {
        //          primaryInput.focus();
        //          var val = primaryInput.value;
        //          primaryInput.value = '';
        //          primaryInput.value = val;
        //          }*/
        //
        //         // reset scroll
        //         layer_popup.scrollTop = 0;
        //
        //         // update
        //         MimotoX.utils.parseRequestQueue();
        //     }
        // });




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
                    let response = request.responseText;

                    // init
                    let parser = new DOMParser();
                    let newDocument = parser.parseFromString(response, "text/html");

                    // isolate
                    let element = newDocument.querySelector('body').firstChild;

                    // register directives
                    MimotoX.display.parseInterface(newDocument.querySelector('body'));

                    // reset scroll
                    layer_popup.scrollTop = 0;

                    // add to dom
                    popup_content.append(element);

                    // collect and execute scripts
                    let aResponseScripts = element.querySelectorAll('script');
                    aResponseScripts.forEach(function(script) { eval(script.text) });

                    // update
                    MimotoX.utils.parseRequestQueue();
                }
            }
        };

        // prepare
        request.open((postData) ? 'post' : 'get', sURL, true);

        // setup
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // prepare
        let sPostData = '';
        for (let sKey in postData)
        {
            if (sPostData.length !== 0) sPostData += '&';
            sPostData += sKey + '=' + postData[sKey];
        }

        // send
        request.send(sPostData);


        return {'popup':'xxx'};
    },

    closePopup: function()
    {
        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
        var popup_content = document.getElementById('Mimoto_popup_content');


        // cleanup directives
        MimotoX.display.cleanupDirectives(popup_content);

        // cleanup
        popup_content.innerHTML = '';

        // hide
        layer_overlay.classList.add('MimotoCMS_hidden');
        layer_popup.classList.add('MimotoCMS_hidden');

        // unlock background for scrolling
        document.body.classList.remove('MimotoCMS_layer_application');
    },

    page: function(sURL)
    {
        // 1. auto return on save?
        // 2. add information about context (for example: section, group title, ...)


        window.open(sURL, '_self');
    },

    log: function()
    {
        if (this.debug === true) console.log.apply(null, arguments);
    },

    warn: function()
    {
        if (this.debug === true) console.warn.apply(null, arguments);
    },

    error: function()
    {
        if (this.debug === true) console.error.apply(null, arguments);
    }

}
