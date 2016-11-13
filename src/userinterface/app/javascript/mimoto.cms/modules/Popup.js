/**
 * Popup
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


    open: function(sURL)
    {
        // register
        var layer_overlay = document.getElementById('layer_overlay');
        var layer_popup = document.getElementById('layer_popup');
        var popup_content = document.getElementById('popup_content');

        // show
        layer_overlay.classList.remove('hidden');
        layer_popup.classList.remove('hidden');

        $.ajax({
            url: sURL,
            dataType: 'html',
            success: function(data, textStatus, jqXHR) {

                //jQuery(selecteur).html(jqXHR.responseText);
                var response = jQuery(jqXHR.responseText);
                //var responseScript = response.filter("script");
                //jQuery.each(responseScript, function(idx, val) { eval(val.text); } );

                //popup_content.innerHTML = reponse;
                $('#popup_content').html(data);

                /*// focus primary input
                 var primaryInput = document.getElementById('form_field_name');
                 if (primaryInput)
                 {
                 primaryInput.focus();
                 var val = primaryInput.value;
                 primaryInput.value = '';
                 primaryInput.value = val;
                 }*/
            }
        });
    },

    close: function()
    {
        // register
        var layer_overlay = document.getElementById('layer_overlay');
        var layer_popup = document.getElementById('layer_popup');
        var popup_content = document.getElementById('popup_content');

        // cleanup
        popup_content.innerHTML = '';

        // hide
        layer_overlay.classList.add('hidden');
        layer_popup.classList.add('hidden');
    }


};



