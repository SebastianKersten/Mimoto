/**
 * Mimoto - InputField - ColorPicker
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elFormField, fBroadcast, aInputElements) {

    // start
    this.__construct(elFormField, fBroadcast, aInputElements);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _aInputElements: null,

    // elements
    _elColorPickerPreview: null,



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    __construct: function(elFormField, fBroadcast, elInput)
    {
        // store
        this._elFormField = elFormField;
        this._fBroadcast = fBroadcast;
        this._elInput = elInput;

        // register
        this._elColorPickerPreview = elFormField.querySelector('[data-mimoto-form-input-colorpicker-preview ]');

        // configure
        this._elInput.addEventListener('input', function(e) { this._correctColorValue(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._correctColorValue(); }.bind(this));

        // show
        this._updateColor(this._elInput.value);
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        // send
        return this._elInput.value;
    },

    setValue: function(value, bDontBroadcastOnInitialSet)
    {
        // update
        this._elInput.value = value;

        // broadcast
        if (!bDontBroadcastOnInitialSet) this._fBroadcast();
    },



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    _correctColorValue: function()
    {
        // register
        let value = this._elInput.value;

        // correct
        value = value.replace(/[^0-9a-f]/i, '');
        value = value.toUpperCase();

        // strip
        if (value.length > 6) value = value.substr(0, 6);

        // update
        this._elInput.value = value;

        // verify and broadcast
        this._fBroadcast();

        // show
        this._updateColor(value);
    },

    _updateColor: function(value)
    {
        // verify
        if (value.length === 3 || value.length === 6)
        {
            // colorize
            this._elColorPickerPreview.style.backgroundColor = '#' + value;
        }
        else
        {
            // reset
            this._elColorPickerPreview.style.backgroundColor = null;
        }
    }

}
