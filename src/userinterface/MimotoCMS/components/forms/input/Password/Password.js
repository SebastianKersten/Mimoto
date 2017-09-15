/**
 * Mimoto - InputField - Textline
 *
 * @author Sebastian Kersten (@supertaboo)
 */

'use strict';


module.exports = function(elFormField, fBroadcast, elInput) {

    // start
    this.__construct(elFormField, fBroadcast, elInput);
};

module.exports.prototype = {

    // dom
    _elFormField: null,
    _fBroadcast: null,
    _elInput: null,



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

        // configure
        this._elInput.addEventListener('input', function(e) { this._fBroadcast(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._fBroadcast(); }.bind(this));
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        return this._elInput.value;
    },

    setValue: function(value)
    {
        this._elInput.value = value;
    }

}
