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

    // data
    user: null,


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
        Mimoto.log('Mimoto starting up ...');

        // 1. logon
        if (this.autoLogon) this._realtimeManager = new RealtimeManager(this.gateway);

        // 2. load cms stylesheet
        if (!document.getElementById('MimotoCMS'))
        {
            if (this.autoloadCSS)
            {
                var head = document.head;
                var link = document.createElement('link');

                link.type = 'text/css';
                link.rel = 'stylesheet';
                link.href = '/mimoto/mimoto.cms.css';

                head.appendChild(link);

                let editorCSS = document.createElement('style');
                editorCSS.innerHTML = ".ql-editor, .ql-container { overflow-y: auto; height: auto; font-size:inherit } .ql-editor { padding: 0; line-height: inherit; font-size:inherit }";
                head.appendChild(editorCSS);
            }
        }

        // 3. connect interface
        this.data = new DataService();
        this.display = new DisplayService(this._realtimeManager);
    },

    /**
     * Listen to data changes
     * @param sPropertySelector
     * @param scope
     * @param fJavascriptDelegate
     */
    listen: function(sPropertySelector, scope, fJavascriptDelegate)
    {
        Mimoto.dom.registerEventListener(sPropertySelector, scope, fJavascriptDelegate);
    },

    popup: function(sURL, postData, bLoadInIFrame)
    {

        if (!document.getElementById('MimotoCMS'))
        {
            var rootElement = document.createElement('div');
            rootElement.setAttribute('id', 'MimotoCMS');

            // var applicationLayer = document.createElement('div');
            // applicationLayer.setAttribute('id', 'mimoto_layer_application');
            // rootElement.appendChild(applicationLayer);

            var overlayLayer = document.createElement('div');
            overlayLayer.setAttribute('id', 'Mimoto_layer_overlay');
            overlayLayer.setAttribute('class', 'MimotoCMS_layer_overlay Mimoto--hidden');
            rootElement.appendChild(overlayLayer);

            var popupLayer = document.createElement('div');
            popupLayer.setAttribute('id', 'Mimoto_layer_popup');
            popupLayer.setAttribute('class', 'MimotoCMS_layer_popup Mimoto--hidden');
            rootElement.appendChild(popupLayer);

            var popup = document.createElement('div');
            popup.setAttribute('id', 'popup');
            popup.setAttribute('class', 'MimotoCMS_interface_Popup');


            popupLayer.appendChild(popup);

            var closeButtonElement = document.createElement('div');
            closeButtonElement.setAttribute('class', 'MimotoCMS_interface_Popup__closebutton');
            closeButtonElement.setAttribute('onclick', 'Mimoto.closePopup();');

            var closeButtonLabel = document.createTextNode('Close');
            closeButtonElement.appendChild(closeButtonLabel);


            var contentElement = document.createElement('div');
            contentElement.setAttribute('id', 'Mimoto_popup_content');
            contentElement.setAttribute('class', 'MimotoCMS_interface_Popup__content');

            popup.appendChild(closeButtonElement);
            popup.appendChild(contentElement);

            document.body.appendChild(rootElement);
        }


        // cleanup
        Mimoto.closePopup();


        // lock background from scrolling
        document.body.classList.add("Mimoto_layer_application");


        // register
        let layer_overlay = document.getElementById('Mimoto_layer_overlay');
        let layer_popup = document.getElementById('Mimoto_layer_popup');
        let popup_content = document.getElementById('Mimoto_popup_content');

        // cleanup #todo - temp solution for popup replace
        popup_content.innerHTML = '';

        // show
        layer_overlay.classList.remove('Mimoto--hidden');
        layer_popup.classList.remove('Mimoto--hidden');


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

                    // reset scroll
                    layer_popup.scrollTop = 0;

                    // add to dom
                    popup_content.append(element);

                    // register directives
                    Mimoto.display.parseInterface(element.parentNode);

                    // collect and execute scripts
                    let aResponseScripts = element.querySelectorAll('script');
                    aResponseScripts.forEach(function(script) { eval(script.text) });
                }
            }
        };

        // prepare
        request.open((postData) ? 'post' : 'get', sURL, true);

        // setup
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // prepare
        let sRequestData = (postData) ? 'data=' + Mimoto.utils.utoa(JSON.stringify(postData)) : null;

        // // send
        request.send(sRequestData);


        return {'popup':'xxx'};
    },

    closePopup: function()
    {
        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
        var popup_content = document.getElementById('Mimoto_popup_content');


        // cleanup directives
        Mimoto.display.cleanupDirectives(popup_content);

        // cleanup
        popup_content.innerHTML = '';

        // hide
        layer_overlay.classList.add('Mimoto--hidden');
        layer_popup.classList.add('Mimoto--hidden');

        // unlock background for scrolling
        document.body.classList.remove('Mimoto_layer_application');
    },

    page: function(sMethod, sURL, data, target)
    {
        let form = document.createElement("form");
        form.action = sURL;
        form.method = sMethod;
        form.target = target || "_self";

        if (data)
        {
            for (let sKey in data)
            {
                let input = document.createElement("textarea");
                input.name = sKey;
                input.value = typeof data[sKey] === "object" ? JSON.stringify(data[sKey]) : data[sKey];
                form.appendChild(input);
            }
        }

        // add referrer
        let input = document.createElement("textarea");
        input.name = 'Mimoto_referrer';
        input.value = window.location.href.split('?')[0];
        form.appendChild(input);


        form.style.display = 'none';
        document.body.appendChild(form);
        form.submit();

        // 1. auto return on save?
        // 2. add information about context (for example: section, group title, ...)
    },

    log: function()
    {
        if (this.debug === true && console) console.log.apply(null, arguments);
    },

    warn: function()
    {
        if (this.debug === true && console) console.warn.apply(null, arguments);
    },

    error: function()
    {
        if (this.debug === true && console) console.error.apply(null, arguments);
    },

    filterSelectionPopup: function(elFilterInput)
    {
        // 1. read
        let sFilterValue = elFilterInput.value;

        // 2. locate
        let elContainer = elFilterInput.parentNode.querySelector('[data-selection-itemcontainer]');

        // 3. filter
        let nItemCount = elContainer.children.length;
        for (let nItemIndex = 0; nItemIndex < nItemCount; nItemIndex++)
        {
            // a. register
            let elItem = elContainer.children[nItemIndex];

            // b. locate
            let elValue = elItem.querySelector('[data-selection-item-value]');

            // c. register
            let sValue = elValue.innerHTML.replace(/<(.|\n)*?>/g, '');

            // d. init
            let pattern = new RegExp(sFilterValue, 'i');

            // e. validate
            if (sValue.match(pattern))
            {
                // I. show
                elItem.classList.remove('Mimoto--hidden');
            }
            else
            {
                // II. hide
                elItem.classList.add('Mimoto--hidden');
            }

        }
    }

}
