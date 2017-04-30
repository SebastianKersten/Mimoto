/**
 * Mimoto - An ultra fast, fluid & realtime data management microframework
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


// Mimoto classes
let DomUtils = require('./modules/DomUtils');
let DomService = require('./modules/DomService');
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

    // config
    debug: null,
    gateway: null,


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
        this.debug = false;
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

        // update
        MimotoX.utils.parseRequestQueue();

        // logon
        this._realtimeManager = new RealtimeManager(this.gateway);
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

    popup: function(sURL, bLoadInIFrame = false)
    {
        console.log('sURL', sURL);




        if (!document.getElementById('MimotoCMS'))
        {

            var head = document.head;
            var link = document.createElement('link');

            link.type = 'text/css';
            link.rel = 'stylesheet';
            link.href = '/static/css/mimoto.cms.css';

            head.appendChild(link);



            var rootElement = document.createElement('div');
            rootElement.setAttribute('id', 'MimotoCMS');

            // var applicationLayer = document.createElement('div');
            // applicationLayer.setAttribute('id', 'mimoto_layer_application');
            // rootElement.appendChild(applicationLayer);

            var overlayLayer = document.createElement('div');
            overlayLayer.setAttribute('id', 'Mimoto_layer_overlay');
            overlayLayer.setAttribute('class', 'Mimoto_layer_overlay Mimoto_hidden');
            rootElement.appendChild(overlayLayer);

            var popupLayer = document.createElement('div');
            popupLayer.setAttribute('id', 'Mimoto_layer_popup');
            popupLayer.setAttribute('class', 'Mimoto_layer_popup Mimoto_hidden');
            rootElement.appendChild(popupLayer);

            var popup = document.createElement('div');
            popup.setAttribute('id', 'popup');
            popup.setAttribute('class', 'MimotoCMS_interface_Popup');


            var closeButtonElement = document.createElement('div');
            closeButtonElement.setAttribute('class', 'MimotoCMS_interface_Popup__closebutton');
            closeButtonElement.setAttribute('onclick', 'MimotoX.closePopup();');

            var closeButtonLabel = document.createTextNode('Close');
            closeButtonElement.appendChild(closeButtonLabel);

            var contentElement = document.createElement('div');
            contentElement.setAttribute('id', 'Mimoto_popup_content');
            contentElement.setAttribute('class', 'MimotoCMS_interface_Popup__content');

            popupLayer.appendChild(closeButtonElement);
            popupLayer.appendChild(contentElement);

            document.body.appendChild(rootElement);


            document.body.classList.add("mimoto_layer_application");
        }



        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');

        // show
        layer_overlay.classList.remove('Mimoto_hidden');
        layer_popup.classList.remove('Mimoto_hidden');


        $.ajax({
            url: sURL,
            dataType: 'html',
            success: function(data, textStatus, jqXHR) {

                //jQuery(selecteur).html(jqXHR.responseText);
                var response = jQuery(jqXHR.responseText);
                //var responseScript = response.filter("script");
                //jQuery.each(responseScript, function(idx, val) { eval(val.text); } );

                //popup_content.innerHTML = reponse;
                $('#Mimoto_popup_content').html(data);

                /*// focus primary input
                 var primaryInput = document.getElementById('form_field_name');
                 if (primaryInput)
                 {
                 primaryInput.focus();
                 var val = primaryInput.value;
                 primaryInput.value = '';
                 primaryInput.value = val;
                 }*/

                // reset scroll
                layer_popup.scrollTop = 0;

                // update
                MimotoX.utils.parseRequestQueue();
            }
        });


        // 1. dom manager
        // 2. include Mimoto application layer into dom
        // 3. add popup
        // 4. hide others
        // 5. popup layout
        // 6. load css
        // 7. load mimoto.cms.js (general create, update, delete api in deze javascript
        // 8. Mimoto.data.create('type', id)


        return {'popup':'xxx'};
    },

    closePopup: function()
    {
        console.log('close!');

        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
        var popup_content = document.getElementById('Mimoto_popup_content');

        // cleanup
        popup_content.innerHTML = '';

        // hide
        layer_overlay.classList.add('Mimoto_hidden');
        layer_popup.classList.add('Mimoto_hidden');


        document.body.classList.remove("mimoto_layer_application");
    }

}
