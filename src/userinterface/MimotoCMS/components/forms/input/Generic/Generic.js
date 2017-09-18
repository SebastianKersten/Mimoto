/**
 * Mimoto - InputField - Generic
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

        // only support one input element
        this._elInput = (Array.isArray(elInput) && elInput[0]) ? elInput[0] : elInput;

        // validate
        if (!this._elInput) return;

        // configure
        this._elInput.addEventListener('input', function(e) { this._fBroadcast(); }.bind(this));
        this._elInput.addEventListener('change', function(e) { this._fBroadcast(); }.bind(this));
    },



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    getValue: function()
    {
        return (this._elInput) ? this._elInput.value : null;
    },

    setValue: function(value)
    {
        if (this._elInput) this._elInput.value = value;
    }

}
