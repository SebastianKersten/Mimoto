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
        this._showPopup();
        this._loadPopupContent(sURL);
    },

    close: function()
    {
        this._hidePopup();
    },
    
    replace: function(sURL)
    {
        this._loadPopupContent(sURL);
    },
    
    _showPopup: function()
    {
        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
    
        // show
        layer_overlay.classList.remove('Mimoto_CoreCSS_hidden');
        layer_popup.classList.remove('Mimoto_CoreCSS_hidden');
    },
    
    _loadPopupContent: function(sURL)
    {
        var popup_content = document.getElementById('Mimoto_popup_content');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
        
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
            }
        });
    },
    
    _hidePopup: function()
    {
        // register
        var layer_overlay = document.getElementById('Mimoto_layer_overlay');
        var layer_popup = document.getElementById('Mimoto_layer_popup');
        var popup_content = document.getElementById('Mimoto_popup_content');
    
        // cleanup
        popup_content.innerHTML = '';
    
        // hide
        layer_overlay.classList.add('Mimoto_CoreCSS_hidden');
        layer_popup.classList.add('Mimoto_CoreCSS_hidden');
    }

};



